<?php
declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Src\Domain\Product\Models\Property;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
