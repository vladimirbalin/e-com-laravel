<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Domain\Catalog\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Src\Domain\Catalog\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => null,
            'is_on_the_main_page' => $this->faker->boolean(10),
            'sorting' => $this->faker->numberBetween(1, 999)
        ];
    }
}
