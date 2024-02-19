<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Providers;

use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }

    public function boot(): void
    {
    }
}
