<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\ViewModels;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Catalog\Models\Category;
use Src\Support\ValueObjects\Price;

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

    public function catalogPage(): Collection|array
    {
        return Brand::query()
            ->select(['id', 'title'])
//            ->when($category->exists, function (Builder $query) use ($category) {
//                $query->whereRelation('products.categories', 'categories.id', $category->id);
//            })
//            ->when(request('filter.price'), function (Builder $query) {
//                $from = (new Price(request('filter.price.from', 0) * 100))->getValue();
//                $to = (new Price(request('filter.price.to', 14200000) * 100))->getValue();
//
//                $query->whereHas('products', fn ($q) => $q->whereBetween('price', [$from, $to]));
//            })
//            ->withCount(['products' => function ($q) use ($category) {
//                $q->when($category->exists, function (Builder $query) use ($category) {
//                    $query->whereRelation('categories', 'categories.id', $category->id);
//                })->when(request('filter.price'), function (Builder $query) {
//                    $from = (new Price(request('filter.price.from', 0) * 100))->getValue();
//                    $to = (new Price(request('filter.price.to', 14200000) * 100))->getValue();
//
//                    $query->whereBetween('price', [$from, $to]);
//                });
//            }])
//            ->orderByDesc('products_count')
            ->orderBy('title')->get();
    }
}
