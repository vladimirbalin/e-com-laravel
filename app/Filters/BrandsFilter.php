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

    #[\Override] public function title(): string
    {
        return 'Бренды (' . $this->brandsQuery()->count() . ')';
    }

    #[\Override] public function key(): string
    {
        return 'brands';
    }

    #[\Override] public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $query) {
            return $query->whereIn('brand_id', $this->requestValue());
        });
    }

    #[\Override] public function values(): array
    {
        return $this->brandsQuery()
            ->get()
            ->pluck('title', 'id')
            ->toArray();
    }

    #[\Override] public function view(): string
    {
        return 'catalog.filters.brands';
    }
}
