<?php

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

class ProductEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('product.title')
                ->required()
                ->title('Title')
                ->placeholder('Enter product title'),
            Input::make('product.slug')
                ->title('Slug')
                ->placeholder('Enter product slug'),
            Input::make('product.price')
                ->title('Price')
                ->mask([
                    'alias' => 'currency',
                    'prefix' => '',
                    'groupSeparator' => '',
                    'digitsOptional' => true,
                    'max' => 42949672,
                ])
                ->placeholder('Enter product price'),
            Cropper::make('product.thumbnail')
                ->storage('images')
                ->acceptedFiles('.jpg')
                ->path(Product::baseFolder())
                ->targetRelativeUrl(),

            Relation::make('product.optionValues.')
                ->fromModel(OptionValue::class, 'title')
                ->displayAppend('full')
                ->title('Option value')
                ->multiple()
                ->empty('Выбрать option Value'),
            Select::make('product.brand_id')
                ->required()
                ->fromModel(Brand::class, 'title')
                ->title('Brand')
                ->empty('Выбрать бренд')
        ];
    }
}
