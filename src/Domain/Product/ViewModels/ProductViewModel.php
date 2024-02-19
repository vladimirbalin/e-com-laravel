<?php
declare(strict_types=1);

namespace Src\Domain\Product\ViewModels;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Product\Models\Product;

class ProductViewModel
{
    public function homePage(): Collection|array
    {
        return Cache::rememberForever('product_main_page', function () {
            return Product::forMainPage()
                ->orderBy('sorting')
                ->limit(8)
                ->get();
        });
    }
}
