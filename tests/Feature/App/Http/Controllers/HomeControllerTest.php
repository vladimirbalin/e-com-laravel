<?php
declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_page_success()
    {
        $brands = BrandFactory::new()->count(25)->create(['is_on_the_main_page' => true, 'sorting' => 999]);
        $categories = CategoryFactory::new()->count(25)->create(['is_on_the_main_page' => true, 'sorting' => 999]);

        $brand = BrandFactory::new()->createOne(['is_on_the_main_page' => true, 'sorting' => 1]);
        $product = ProductFactory::new()->createOne(['is_on_the_main_page' => true, 'sorting' => 1]);
        $category = CategoryFactory::new()->createOne(['is_on_the_main_page' => true, 'sorting' => 1]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('products.0', $product)
            ->assertViewHas('brands.0', $brand)
            ->assertViewHas('categories.0', $category);
    }
}
