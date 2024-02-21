<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Domain\Catalog\Models\Brand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Src\Domain\Catalog\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->unique()->word()),
            'thumbnail' => $this->faker->fixturesImage('brands', 'images/brands'),
            'is_on_the_main_page' => $this->faker->boolean(25),
            'sorting' => $this->faker->numberBetween(1, 999)
        ];
    }
}
