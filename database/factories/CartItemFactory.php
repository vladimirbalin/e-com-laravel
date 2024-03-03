<?php
declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Src\Domain\Cart\Models\Cart;
use Src\Domain\Cart\Models\CartItem;
use Src\Domain\Product\Models\Product;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'quantity' => $this->faker->word(),
            'price' => $this->faker->randomNumber(),
            'cart_id' => Cart::inRandomOrder()->value('id'),
            'product_id' => Product::inRandomOrder()->value('id'),
        ];
    }
}
