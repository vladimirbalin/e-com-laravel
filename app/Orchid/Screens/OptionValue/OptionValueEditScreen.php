<?php

namespace App\Orchid\Screens\OptionValue;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Src\Domain\Product\Models\Option;
use Src\Domain\Product\Models\OptionValue;

class OptionValueEditScreen extends Screen
{
    public $optinValue;

    public function query(OptionValue $optionValue): iterable
    {
        return ['optionValue' => $optionValue];
    }

    public function name(): ?string
    {
        return 'OptionValueEditScreen';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('optionValue.title')
                    ->required()
                    ->title('Title')
                    ->placeholder('Enter option value title'),
                Select::make('optionValue.option_id')
                    ->fromModel(Option::class, 'title')
            ])
        ];
    }
}
