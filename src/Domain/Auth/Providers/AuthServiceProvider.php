<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Providers;

use Src\Domain\Auth\Actions\RegisterAction;
use Src\Domain\Auth\Contracts\Register;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

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
