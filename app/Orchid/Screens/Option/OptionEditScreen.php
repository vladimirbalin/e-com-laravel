<?php

namespace App\Orchid\Screens\Option;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Src\Domain\Product\Models\Option;

class OptionEditScreen extends Screen
{
    public $option;

    public function query(Option $option): iterable
    {
        return ['option' => $option];
    }

    public function name(): ?string
    {
        return 'OptionEditScreen';
    }

    public function commandBar(): iterable
    {
        return [Link::make('Create new')
            ->icon('pencil')
            ->route('platform.options.create')];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('option.title')
                    ->required()
                    ->title('Title')
                    ->placeholder('Enter option title'),

            ])
        ];
    }
}
