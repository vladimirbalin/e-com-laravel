<?php
declare(strict_types=1);

namespace Jobs;

use App\Jobs\SavePropertiesForProductJob;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductJsonPropertiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_created_json_properties()
    {
        $queue = Queue::getFacadeRoot();
        Queue::fake([SavePropertiesForProductJob::class]);

        $product = ProductFactory::new()
            ->for(BrandFactory::new())
            ->hasAttached(PropertyFactory::new()->count(5), function () {
                return ['value' => fake()->word()];
            })->create();

        $this->assertNull($product->json_properties);

        Queue::swap($queue);
        SavePropertiesForProductJob::dispatchSync($product);

        $product->refresh();
        $this->assertNotEmpty($product->json_properties);
    }
}
