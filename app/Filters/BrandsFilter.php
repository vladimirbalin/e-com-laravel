<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Src\Domain\Catalog\Filters\AbstractFilter;
use Src\Domain\Catalog\Models\Brand;

class BrandsFilter extends AbstractFilter
{
    private function brandsQuery(): Builder
    {
        return Brand::query()
            ->select(['title', 'id'])
            ->has('products');
    }

    public function title(): string
    {
        return 'Бренды (' . $this->brandsQuery()->count() . ')';
    }

    public function key(): string
    {
        return 'brands';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $query) {
            return $query->whereIn('brand_id', $this->requestValue());
        });
    }

    public function values(): array
    {
        return $this->brandsQuery()
            ->get()
            ->pluck('title', 'id')
            ->toArray();
    }

    public function view(): string
    {
        return 'catalog.filters.brands';
    }
}
