<?php
declare(strict_types=1);

use Src\Domain\Catalog\Filters\FilterManager;
use Src\Domain\Catalog\Models\Category;
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
if (! function_exists('sortings')) {
    function sortings(): array
    {
        return app(FilterManager::class)->sortings();
    }
}

if (! function_exists('catalog_filters_url')) {
    function catalog_filters_url(?Category $category, array $params = []): string
    {
        return route('catalog.index', [
            'category' => $category,
            ...['filters' => [...request('filters', []), ...$params]]
        ]);
    }
}


