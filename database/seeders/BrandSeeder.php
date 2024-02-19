<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Domain\Catalog\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory(30)->create();
    }
}
