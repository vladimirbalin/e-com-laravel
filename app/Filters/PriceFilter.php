<?php
declare(strict_types=1);

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Src\Domain\Catalog\Filters\AbstractFilter;
use Src\Support\ValueObjects\Price;

class PriceFilter extends AbstractFilter
{
    #[\Override] public function title(): string
    {
        return 'Цена';
    }

    #[\Override] public function key(): string
    {
        return 'price';
    }

    #[\Override] public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $query) {
            return $query->whereBetween('price', [$this->from(), $this->to()]);
        });
    }

    private function from(): int
    {
        return (new Price($this->requestValue('from', 0) * 100))->getIntegerFormattedValue();
    }

    private function to(): int
    {
        return (new Price($this->requestValue('to', max_product_price()) * 100))->getIntegerFormattedValue();
    }

    #[\Override] public function view(): string
    {
        return 'catalog.filters.price';
    }

    #[\Override] public function values(): array
    {
        // TODO: Implement values() method.
    }
}
