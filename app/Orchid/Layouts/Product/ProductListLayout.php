<?php

namespace App\Orchid\Layouts\Product;

use App\View\Components\PriceShortInformation;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Src\Domain\Product\Models\Product;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->width('100')
                ->render(fn (Product $product) =>
                view('components.thumbnail-products-table',
                    ['src' => $product->makeThumbnail('50x50'), 'alt' => 'Product-' . $product->id, 'id' => $product->id])),
            TD::make('title', 'Title')
                ->render(function (Product $product) {
                    return Link::make($product->title)
                        ->route('platform.products.edit', $product->slug);
                }),
            TD::make('slug', 'Slug'),
            TD::make('thumbnail', 'Картинка'),
            TD::make('price', 'Цена')
                ->usingComponent(PriceShortInformation::class),

            TD::make('created_at', 'Created')
                ->render(function (Product $product) {
                    return $product->created_at->format('Y-m-d H:i:s');
                }),
            TD::make('updated_at', 'Last edit')
                ->render(function (Product $product) {
                    return $product->updated_at->format('Y-m-d H:i:s');
                })
        ];
    }
}
