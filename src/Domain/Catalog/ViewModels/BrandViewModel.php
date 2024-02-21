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

    public function catalogPage(Category $category): Collection|array
    {
        return Brand::query()
            ->select(['id', 'title'])
            ->whereHas('products', function (Builder $q) use ($category) {
                $this->filtersForProducts($q, $category);
            })
            ->withCount(['products' => function ($q) use ($category) {
                $this->filtersForProducts($q, $category);
            }])
            ->orderByDesc('products_count')
            ->orderBy('title')->get();
    }

    private function filtersForProducts($query, $category): void
    {
        $query
            ->whereHas('categories',
                fn (Builder $q) => $q->when($category->exists,
                    fn (Builder $q) => $q->whereCategoryId($category->id)
                ))
            ->when(request('filter.price'), function (Builder $query) {
                return $query->whereBetween('price',
                    [(new Price(request('filter.price.from', 0) * 100))->getValue(),
                        (new Price(request('filter.price.to', 14200000) * 100))->getValue()]
                );
            });
    }
}
