<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Catalog\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Brand::factory(30)->create();

        Storage::createDirectory('images/products');

        Product::factory(50)
            ->has(Category::factory(rand(1, 3)))
            ->create();
    }
}
