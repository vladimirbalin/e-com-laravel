<?php
declare(strict_types=1);

namespace Src\Domain\Product\ViewModels;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Product\Models\Product;

class ProductViewModel
{
    public function homePage(): Collection|array
    {
        $callback = fn () => Product::forMainPage()
            ->with('brand:id,title')
            ->orderBy('sorting')
            ->limit(8)
            ->get();

        return $this->remember('product_main_page', $callback);
    }

    public function catalogPage(Category $category): LengthAwarePaginator
    {
        return Product::query()
            ->with('brand:id,title')
            ->select(['id', 'title', 'slug', 'thumbnail', 'price', 'brand_id'])
            ->when($category->exists, function (Builder $query) use ($category) {
                $query->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id));
            })
            ->filtered()
            ->sorted()
            ->paginate(9);
    }

    private function remember(string $name, callable $callback)
    {
        return Cache::rememberForever($name, $callback);
    }
}
