<?php

declare(strict_types=1);

namespace Src\Domain\Catalog\Providers;

use App\Filters\SortFilter;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Src\Domain\Catalog\Filters\FilterManager;
use Src\Domain\Catalog\Models\Filter;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ActionsServiceProvider::class);
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        try {
            $filters = Filter::select(['id', 'name', 'namespace'])
                ->get()
                ->map(fn ($filter) => new $filter->namespace)
                ->toArray();

            app(FilterManager::class)
                ->registerFilters($filters)
                ->registerSortings([
                    new SortFilter()
                ]);
        } catch (Exception $e) {
            Log::warning($e->getMessage());
        }
    }
}
