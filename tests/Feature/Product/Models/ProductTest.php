<?php
declare(strict_types=1);

namespace Tests\Feature\Product\Models;

use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Support\ValueObjects\Price;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_price_cast_success()
    {
        $brand = BrandFactory::new()->createOne();
        $product = ProductFactory::new()->createOne(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Price::class, $product->price);

        $roubles = 25000;
        $product->price = $roubles;
        $this->assertEquals($roubles * 100, $product->price->getValue());
    }
}
