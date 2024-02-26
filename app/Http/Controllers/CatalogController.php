<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Catalog\ViewModels\BrandViewModel;
use Src\Domain\Catalog\ViewModels\CategoryViewModel;
use Src\Domain\Product\ViewModels\ProductViewModel;


class CatalogController extends Controller
{
    public function __construct(
        private BrandViewModel    $brandViewModel,
        private CategoryViewModel $categoryViewModel,
        private ProductViewModel  $productViewModel,
    ) {
    }

    public function __invoke(Category $category, Request $request)
    {
        $categories = $this->categoryViewModel->homePage();
        $brands = $this->brandViewModel->catalogPage($category);
        $products = $this->productViewModel->catalogPage($category);

        return view('catalog.index', compact(
                'categories',
                'products',
                'brands',
                'category'
            )
        );
    }
}
