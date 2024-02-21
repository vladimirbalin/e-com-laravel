<?php
declare(strict_types=1);

use Src\Domain\Product\QueryBuilders\ProductQueryBuilder;
use Src\Support\Flash\Flash;

if (! function_exists('flash')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
if (! function_exists('max_price')) {
    function max_price(): ?int
    {
        $price = app(ProductQueryBuilder::class)->maxPrice();

        return $price ?? (int) $price;
    }
}
