<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\ViewModels;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Catalog\Models\Category;

class BrandViewModel
{
    public function homePage(): Collection|array
    {
        return Cache::rememberForever('brands_main_page', function () {
            return Brand::forMainPage()
                ->orderBy('sorting')
                ->limit(6)
                ->get();
        });
    }
}
