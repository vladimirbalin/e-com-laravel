<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Src\Domain\Product\Models\Product;
use Src\Support\ValueObjects\Price;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 1,
                            ]),

                        Forms\Components\TextInput::make('slug'),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->mask(RawJs::make('$money($input, \'.\', \' \')'))
                            ->formatStateUsing(fn (?Product $product) => (new Price($product->price ?? 0))->getFormattedValue())
                            ->dehydrateStateUsing(fn ($state) => $state * 100)
                            ->prefix('₽'),

                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'title'),

                        Forms\Components\FileUpload::make('thumbnail')
                            ->disk('images')
                            ->directory('products')
                            ->formatStateUsing(function ($state, string $operation) {
                                if ($operation === 'create') return;

                                return [str($state)->ltrim('/storage/images/')->value()];
                            })
                            ->dehydrateStateUsing(fn (array $state) => str(reset($state))
                                ->prepend('/storage/images/')->value())

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->sortable()
                    ->date('Y-m-d H:i:s')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OptionValuesRelationManager::class,
            RelationManagers\PropertiesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
