<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Domain\Catalog\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(20)->create();
    }
}
