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
            ->with(['brand:id,title', 'properties:id,title'])
            ->orderBy('sorting')
            ->limit(8)
            ->get();

        return $this->remember('product_main_page', $callback);
    }

    public function catalogPage(Category $category): LengthAwarePaginator
    {
        return Product::query()
            ->select(['id', 'title', 'slug', 'thumbnail', 'price', 'brand_id', 'json_properties'])
            ->with(['brand:id,title', 'properties:id,title'])
            ->filtered()
            ->ofCategory($category)
            ->when(request('filters.search'),
                fn (Builder $query) => $query->whereFullText(['title', 'text'], request('filters.search')))
            ->sorted()
            ->paginate(9);
    }

    private function remember(string $name, callable $callback)
    {
        return Cache::rememberForever($name, $callback);
    }
}
