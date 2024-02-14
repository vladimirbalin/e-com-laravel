<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Auth\Actions\RegisterAction;
use Src\Domain\Auth\Contracts\Register;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [];

    public function register(): void
    {
        $this->app->bind(Register::class, RegisterAction::class);
    }

    public function boot(): void
    {
    }
}
