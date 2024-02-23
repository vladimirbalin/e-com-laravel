<?php
declare(strict_types=1);

namespace Src\Domain\Product\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Product\Models\Product;

class ProductQueryBuilder extends Builder
{
    public function forMainPage(): Builder
    {
        return $this->where('is_on_the_main_page', true);
    }

    public function filtered(): Builder
    {
        return $this
            ->when(request('filter.brands'), function (Builder $query) {
                return $query->whereIn('brand_id', request('filter.brands'));
            })
            ->when(request('filter.price'), function (Builder $query) {
                return $query->whereBetween('price',
                    [request('filter.price.from', 0) * 100,
                        request('filter.price.to', 14200000) * 100]
                );
            })
            ->when(request('category'), function (Builder $query) {
                return $query->whereHas('categories', fn ($q) => $q->where('categories.id', request('category')->id));
            });
    }

    public function sorted(): Builder
    {
        return $this
            ->when(request('filters.sort'), function (Builder $query) {
                $sort = request()->str('filters.sort');

                if (! $sort->contains(['price', 'title'])) {
                    return $query;
                }

                $direction = $sort->contains('-') ? 'DESC' : 'ASC';
                return $query->orderBy($sort->remove('-'), $direction);
            });
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
}
