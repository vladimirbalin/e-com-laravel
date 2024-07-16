<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Filters\BrandsFilter;
use App\Filters\PriceFilter;
use Illuminate\Database\Seeder;
use Src\Domain\Catalog\Models\Filter;

class FilterSeeder extends Seeder
{
    public function run(): void
    {
        Filter::create([
            'name' => 'price',
            'namespace' => PriceFilter::class
        ]);

        Filter::create([
            'name' => 'brands',
            'namespace' => BrandsFilter::class
        ]);
    }
}
