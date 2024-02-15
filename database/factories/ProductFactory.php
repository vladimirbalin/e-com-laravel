<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products/' . today()->format('Y-m-d')),
            'price' => $this->faker->numberBetween(1000, 100000),
            'sorting' => $this->faker->numberBetween(1, 999),
            'is_on_the_main_page' => $this->faker->boolean(25)
        ];
    }

    public function withTitle(string $title): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => $title,
        ]);
    }
}
