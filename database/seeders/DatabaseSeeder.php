<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Product\Models\Product;

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
        BrandFactory::new()->count(25)->create();

        Storage::createDirectory('images/products');
        CategoryFactory::new()->count(20)->create();
        ProductFactory::new()->count(500)
            ->create();

        $products = Product::all();
        $categories = Category::select(['id'])->get();

        $products->each(
            fn (Product $product) => $product->categories()->attach($categories->random(rand(1, 4))));
    }
}
