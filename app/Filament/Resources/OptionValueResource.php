<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionValueResource\Pages;
use App\Filament\Resources\OptionValueResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Src\Domain\Product\Models\OptionValue;

class OptionValueResource extends Resource
{
    protected static ?string $model = OptionValue::class;

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
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        TextInput::make('title')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 4,
                            ]),
                        Forms\Components\Select::make('option_id')
                            ->relationship('option', 'title')
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 4,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('title')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOptionValues::route('/'),
            'create' => Pages\CreateOptionValue::route('/create'),
            'edit' => Pages\EditOptionValue::route('/{record}/edit'),
        ];
    }
}
