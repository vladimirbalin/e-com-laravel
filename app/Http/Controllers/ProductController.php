<?php
declare(strict_types=1);

namespace App\Http\Controllers;

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

        $product->load(['optionValues.option:id,title', 'properties:title']);
        $options = $product->optionValues->keyValues();

        return view('product.show',
            compact(
                'product',
                'options',
                'watchedProducts',
            ));
    }
}
