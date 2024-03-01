<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Providers;

use App\Filters\BrandsFilter;
use App\Filters\PriceFilter;
use App\Filters\SortFilter;
use Illuminate\Support\ServiceProvider;
use Src\Domain\Catalog\Filters\FilterManager;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ActionsServiceProvider::class);
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)
            ->registerFilters([
                new PriceFilter(),
                new BrandsFilter()
            ])->registerSortings([
                new SortFilter()
            ]);
    }
}
