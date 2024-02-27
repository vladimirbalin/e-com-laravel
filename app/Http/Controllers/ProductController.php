<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {
        if (session()->has('watched.' . $product->id)) {
            session()->forget('watched.' . $product->id);
        }
        $watchedProducts = $product->getPreviouslyWatched();
        session()->put('watched.' . $product->id, $product->id);

        $product->load('optionValues.option');
        $options = $product->optionValues->mapToGroups(function (OptionValue $optionValue) {
            return [$optionValue->option->title => $optionValue];
        });

        return view('product.show', compact('product', 'options', 'watchedProducts'));
    }
}
