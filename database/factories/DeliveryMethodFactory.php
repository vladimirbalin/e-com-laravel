<?php
declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Src\Domain\Order\Models\DeliveryMethod;

class DeliveryMethodFactory extends Factory
{
    protected $model = DeliveryMethod::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'title' => $this->faker->word(),
            'price' => $this->faker->randomNumber(),
            'with_address' => $this->faker->address(),
        ];
    }
}
