<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Catalog\Models\Brand;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([

                    Forms\Components\TextInput::make('title')
                        ->required(),
                    Forms\Components\TextInput::make('slug'),

                    Forms\Components\FileUpload::make('thumbnail')
                        ->disk('images')
                        ->directory('brands')
                        ->formatStateUsing(fn ($state) => [str($state)->ltrim('/storage/images/')->value()])
                        ->dehydrateStateUsing(fn (array $state) => str(reset($state))
                            ->prepend('/storage/images/')->value())
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('created_at')
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
            RelationManagers\ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
