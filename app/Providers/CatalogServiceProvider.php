<?php
declare(strict_types=1);

namespace App\Providers;

use App\Filters\BrandsFilter;
use App\Filters\PriceFilter;
use Illuminate\Support\ServiceProvider;
use Src\Domain\Catalog\Filters\FilterManager;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandsFilter()
        ]);
    }
}
