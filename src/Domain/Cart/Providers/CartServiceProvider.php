<?php
declare(strict_types=1);

namespace Src\Domain\Cart\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Cart\CartManager;
use Src\Domain\Cart\Contracts\CartIdentityStorageContract;
use Src\Domain\Cart\StorageIdentities\SessionIdentityStorage;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CartIdentityStorageContract::class, SessionIdentityStorage::class);
        $this->app->singleton(CartManager::class);
    }

    public function boot(): void
    {
    }
}
