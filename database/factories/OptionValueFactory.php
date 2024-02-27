<?php
declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Src\Domain\Product\Models\Option;
use Src\Domain\Product\Models\OptionValue;

class OptionValueFactory extends Factory
{
    protected $model = OptionValue::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word),
            'option_id' => Option::inRandomOrder()->value('id'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
