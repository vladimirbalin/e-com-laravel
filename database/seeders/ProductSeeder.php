<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Domain\Product\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(100)->create();
    }
}
