<?php
declare(strict_types=1);

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Src\Domain\Catalog\Filters\AbstractFilter;
use Src\Support\ValueObjects\Price;

class PriceFilter extends AbstractFilter
{
    public function title(): string
    {
        return 'Цена';
    }

    public function key(): string
    {
        return 'price';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $query) {
            return $query->whereBetween('price', [$this->from()->getValue(), $this->to()->getValue()]);
        });
    }

    public function from(): Price
    {
        return (new Price(
            $this->requestValue('from', 0) * 100)
        );
    }

    public function to(): Price
    {
        return (new Price(
            $this->requestValue('to', max_product_price()) * 100)
        );
    }

    public function values(): array
    {
        return [
            'from' => $this->from()->getPreparedValue(),
            'to' => $this->to()->getPreparedValue(),
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }
}
