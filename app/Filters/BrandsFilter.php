<?php
declare(strict_types=1);

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Src\Domain\Catalog\Filters\AbstractFilter;
use Src\Domain\Catalog\Models\Brand;

class BrandsFilter extends AbstractFilter
{
    private $brandsQuery;

    public function __construct()
    {
        $this->brands = Brand::query()
            ->select(['title', 'id'])
            ->has('products');
    }

    #[\Override] public function title(): string
    {
        return 'Бренды (' . $this->brands->count() . ')';
    }

    #[\Override] public function key(): string
    {
        return 'brands';
    }

    #[\Override] public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue('brands'), function (Builder $query) {
            return $query->whereIn('brand_id', $this->requestValue('brands'));
        });
    }

    #[\Override] public function values(): array
    {
        return $this->brands
            ->get()
            ->pluck('title', 'id')
            ->toArray();
    }

    #[\Override] public function view(): string
    {
        return 'catalog.filters.brands';
    }
}
