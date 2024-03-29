<?php
declare(strict_types=1);

namespace Src\Domain\Product\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Pipeline;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Product\Models\Product;

class ProductQueryBuilder extends Builder
{
    public function forMainPage(): Builder
    {
        return $this->where('is_on_the_main_page', true);
    }

    public function filtered(): Builder
    {
        return Pipeline::send($this)
            ->through(filters())
            ->thenReturn();
//        return $this
//            ->when(request('filter.brands'), function (Builder $query) {
//                return $query->whereIn('brand_id', request('filter.brands'));
//            })
//            ->when(request('filter.price'), function (Builder $query) {
//                return $query->whereBetween('price',
//                    [request('filter.price.from', 0) * 100,
//                        request('filter.price.to', 14200000) * 100]
//                );
//            })
//            ->when(request('category'), function (Builder $query) {
//                return $query->whereHas('categories', fn ($q) => $q->where('categories.id', request('category')->id));
//            });
    }

    public function sorted(): Builder
    {
        return Pipeline::send($this)
            ->through(sortings())
            ->thenReturn();
//            ->when(request('filters.sort'), function (Builder $query) {
//                $sort = request()->str('filters.sort');
//
//                if (! $sort->contains(['price', 'title'])) {
//                    return $query;
//                }
//
//                $direction = $sort->contains('-') ? 'DESC' : 'ASC';
//                return $query->orderBy($sort->remove('-'), $direction);
//            });
    }

    public function maxPrice(): int
    {
        return Cache::rememberForever('max_product_price', function () {
            $maxPrice = Product::query()
                ->orderByDesc('price')
                ->value('price')
                ?->getPreparedValue();

            if (is_null($maxPrice)) {
                throw new \Exception('No max price');
            }

            return (int) $maxPrice;
        });
    }

    public function getPreviouslyWatched(): Collection
    {
        $watchedIdsFromSession = session('watched', []);

        $watchedProducts = Product::select(['id', 'title', 'brand_id', 'slug', 'thumbnail', 'price'])
            ->whereIn('id', $watchedIdsFromSession)
            ->with('brand:id,title');

        if (count($watchedIdsFromSession) > 0) {
            $ids = implode(',', array_reverse($watchedIdsFromSession));
            $watchedProducts->orderByRaw("FIELD(id, $ids)");
        }

        return $watchedProducts->get();
    }

    public function ofCategory(Category $category)
    {
        return $this->when($category->exists,
            fn (Builder $query) => $query->whereRelation('categories', 'categories.id', $category->getKey()));
    }
}
