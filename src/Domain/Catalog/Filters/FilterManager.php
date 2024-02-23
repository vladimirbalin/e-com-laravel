<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Filters;

class FilterManager
{
    public function __construct(
        private array $filters = []
    ) {
    }

    public function registerFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function filters(): array
    {
        return $this->filters;
    }

}
