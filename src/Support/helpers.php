<?php
declare(strict_types=1);

use Src\Domain\Catalog\Filters\FilterManager;
use Src\Domain\Product\QueryBuilders\ProductQueryBuilder;
use Src\Support\Flash\Flash;

if (! function_exists('flash')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
if (! function_exists('max_product_price')) {
    function max_product_price(): ?int
    {
        return app(ProductQueryBuilder::class)->maxPrice();
    }
}
if (! function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->filters();
    }
}
