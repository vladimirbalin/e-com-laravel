<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaravelIdea\Helper\Src\Domain\Product\Models\_IH_OptionValue_QB;
use Src\Domain\Product\Models\OptionValue;

class OptionValuesRelationManager extends RelationManager
{
    protected static string $relationship = 'optionValues';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('option.title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelect(
                        fn (Select $select) => $select->placeholder('Select a option value')
                            ->options(function () {
                                return OptionValue::query()
                                    ->select(['id', 'title', 'option_id'])
                                    ->with('option:id,title')
                                    ->get()
                                    ->map(function (OptionValue $optionValue) {
                                        return "{$optionValue->title} : {$optionValue->option->title}";
                                    })->toArray();
                            }),
                    )
                    ->preloadRecordSelect()
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                ]),
            ]);
    }
}
