<?php

namespace App\Providers;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        Model::shouldBeStrict(! app()->isProduction());

        DB::whenQueryingForLongerThan(500, function (Connection $connection) {
            $this->log('Query took too long time to execute: ' . $connection->query()->toSql());
        });

        if ($this->app->runningInConsole()) {
            // Log slow commands.
            $this->app[ConsoleKernel::class]->whenCommandLifecycleIsLongerThan(
                CarbonInterval::seconds(5),
                function ($startedAt, $input, $status) {
                    $this->log('Command request is too long: ' . request()->url());
                }
            );
        } else {
            // Log slow requests.
            $this->app[HttpKernel::class]->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(5),
                function ($startedAt, $request, $response) {
                    $this->log('Http request is too long: ' . request()->url());
                }
            );
        }
    }

    private function log(string $message): void
    {
        logger()
            ->channel('telegram')
            ->debug($message);
    }
}
