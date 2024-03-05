<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Product\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Src\Domain\Product\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products/' . today()->format('Y-m-d')),
            'price' => $this->faker->numberBetween(100000, 10000000),
            'sorting' => $this->faker->numberBetween(1, 999),
            'is_on_the_main_page' => $this->faker->boolean(25),
            'text' => $this->faker->realText(),
            'quantity' => $this->faker->numberBetween(0, 20),
            'json_properties' => null
        ];
    }

    public function withTitle(string $title): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => $title,
        ]);
    }
}
