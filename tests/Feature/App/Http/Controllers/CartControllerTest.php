<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Domain\Cart\CartManager;
use Src\Support\ValueObjects\Price;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();
    }

    public function testIndex()
    {
        $this->get(route('cart.index'))
            ->assertOk()
            ->assertViewHas('cart', null)
            ->assertViewHas('totalPrice', new Price(0));
    }

    public function testAddProductToCart(): void
    {
        $product = ProductFactory::new()->for(BrandFactory::new())->create();

        $cart = cart()->add($product);

        $this->get(route('cart.index', $product))
            ->assertOk()
            ->assertViewHas('cart', $cart)
            ->assertViewHas('totalPrice', $product->price);
    }
}
