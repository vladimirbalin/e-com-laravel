<?php

namespace App\Orchid\Layouts\Option;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Src\Domain\Product\Models\Option;

class OptionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'options';

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
                ->render(function (Option $option) {
                    return Link::make($option->title)
                        ->route('platform.options.edit', $option);
                }),
        ];
    }
}
