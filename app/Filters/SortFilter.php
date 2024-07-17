<?php
declare(strict_types=1);

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Src\Domain\Catalog\Filters\AbstractFilter;

class SortFilter extends AbstractFilter
{
    public function title(): string
    {
        return 'Сортировать по';
    }

    public function key(): string
    {
        return 'sort';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $query) {
            $sort = request()->str('filters.sort');

            if (! $sort->contains(['price', 'title'])) {
                return $query;
            }

            $direction = $sort->contains('-') ? 'DESC' : 'ASC';
            return $query->orderBy($sort->remove('-'), $direction);
        });
    }

    public function values(): array
    {
        return [
            '' => 'По умолчанию',
            'title' => 'По наименованию',
            'price' => 'От дешевых к дорогим',
            '-price' => 'От дорогих к дешевым',
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.sort';
    }
}
