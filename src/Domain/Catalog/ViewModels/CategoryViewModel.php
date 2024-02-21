<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\ViewModels;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Catalog\Models\Category;

class CategoryViewModel
{
    public function homePage(): Collection|array
    {
        return Cache::rememberForever('categories_main_page', function () {
            return Category::select(['id', 'title', 'slug'])
                ->forMainPage()
                ->orderBy('sorting')
                ->limit(10)
                ->get()
                ->alphabet();
        });
    }

    public function catalogPage(): Collection|array
    {
        return Cache::rememberForever('categories_catalog_page', function () {
            return Category::select(['id', 'title', 'slug'])
                ->forMainPage()
                ->orderBy('sorting')
                ->limit(10)
                ->get()
                ->alphabet();
        });
    }
}
