<?php
declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Src\Domain\Auth\Models\User;
use Src\Domain\Cart\Models\Cart;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'storage_id' => $this->faker->domainWord(),
            'user_id' => User::inRandomOrder()->value('id')
        ];
    }
}
