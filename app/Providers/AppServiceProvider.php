<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $notInProd = ! app()->isProduction();

        \Illuminate\Database\Eloquent\Model::preventSilentlyDiscardingAttributes($notInProd);
        \Illuminate\Database\Eloquent\Model::preventLazyLoading($notInProd);

        \Illuminate\Support\Facades\DB::whenQueryingForLongerThan(500, function (\Illuminate\Database\Connection $connection) {

        });

        // req cycle
        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function () {

            }
        );
    }
}
