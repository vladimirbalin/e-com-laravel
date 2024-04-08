<?php

declare(strict_types=1);

namespace Src\Domain\Order\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(PaymentServiceProvider::class);
    }

    public function boot(): void
    {
    }
}
