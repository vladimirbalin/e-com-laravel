<?php

namespace App\Providers;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->when(ImageManager::class)
            ->needs('$driver')
            ->give(Driver::class);
    }

    public function boot(): void
    {
//        Model::shouldBeStrict(! $this->app->isProduction());

        if ($this->app->isProduction()) {

            if ($this->app->runningInConsole()) {
                // Log slow commands.
                $this->app[ConsoleKernel::class]->whenCommandLifecycleIsLongerThan(
                    CarbonInterval::seconds(5),
                    function ($startedAt, $input, $status) {
                        $this->log('Command request took too long: ' . $input);
                    }
                );
            } else {
                // Log slow requests.
                $this->app[HttpKernel::class]->whenRequestLifecycleIsLongerThan(
                    CarbonInterval::seconds(5),
                    function ($startedAt, $request, $response) {
                        $this->log('Http request took too long: ' . $request->url());
                    }
                );
            }

            DB::listen(function ($query) {
                $time = 100;
                if ($query->time > $time) {
                    $this->log(sprintf('query longer than time %d ms: %d ms. SQL: %s', $time, $query->time, $query->sql));
                }
            });
        }
    }

    private function log(string $message): void
    {
        logger()
            ->channel('telegram')
            ->debug($message);
    }
}
