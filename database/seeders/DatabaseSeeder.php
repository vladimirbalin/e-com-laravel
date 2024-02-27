<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Product\Models\Product;
use Src\Domain\Product\Models\Property;

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

        OptionFactory::new()->count(2)->create();
        $optionValues = OptionValueFactory::new()->count(10)->create();
        $properties = PropertyFactory::new()->count(10)->create();

        $products = Product::all();
        $categories = Category::select(['id'])->get();

        $products->each(
            function (Product $product) use ($categories, $optionValues, $properties) {
                $product->categories()->attach($categories->random(rand(1, 4)));
                $product->optionValues()->attach($optionValues->random(rand(3, 5)));

                $properties = $properties->random(rand(5, 10));
                $properties->each(
                    fn (Property $property) => $product->properties()->attach($property->id, ['value' => fake()->word()]));
            });

    }
}
