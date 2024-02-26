<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Filters;

class FilterManager
{
    public function __construct(
        private array $filters = [],
        private array $sortings = [],
    ) {
    }

    public function registerFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function registerSortings(array $sortings): self
    {
        $this->sortings = $sortings;

        return $this;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function sortings(): array
    {
        return $this->sortings;
    }

}
