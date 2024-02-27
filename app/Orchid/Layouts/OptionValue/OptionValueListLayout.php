<?php

namespace App\Orchid\Layouts\OptionValue;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Src\Domain\Product\Models\OptionValue;

class OptionValueListLayout extends Table
{
    protected $target = 'option-values';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->width('100'),
            TD::make('title', 'Title')
                ->render(function (OptionValue $optionValue) {
                    return Link::make($optionValue->title)
                        ->route('platform.option-values.edit', $optionValue);
                }),
        ];
    }
}
