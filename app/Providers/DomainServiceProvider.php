<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Auth\Providers\AuthServiceProvider;
use Src\Domain\Cart\Providers\CartServiceProvider;
use Src\Domain\Catalog\Providers\CatalogServiceProvider;
use Src\Domain\Order\Providers\OrderServiceProvider;
use Src\Domain\Product\Providers\ProductServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(AuthServiceProvider::class,);
        $this->app->register(CatalogServiceProvider::class);
        $this->app->register(ProductServiceProvider::class);
        $this->app->register(CartServiceProvider::class);
        $this->app->register(OrderServiceProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
