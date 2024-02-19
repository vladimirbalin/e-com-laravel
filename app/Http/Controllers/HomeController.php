<?php

namespace App\Http\Controllers;

use Src\Domain\Catalog\ViewModels\BrandViewModel;
use Src\Domain\Catalog\ViewModels\CategoryViewModel;
use Src\Domain\Product\ViewModels\ProductViewModel;

class HomeController extends Controller
{
    public function __construct(
        private readonly CategoryViewModel $categoryViewModel,
        private readonly BrandViewModel    $brandViewModel,
        private readonly ProductViewModel  $productViewModel,

    ) {
    }

    public function __invoke()
    {
        $categories = $this->categoryViewModel->homePage();
        $brands = $this->brandViewModel->homePage();
        $products = $this->productViewModel->homePage();

        return view('welcome',
            compact('categories', 'brands', 'products'));
    }
}
