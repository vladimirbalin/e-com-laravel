<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Providers;

use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [];

    public function register(): void
    {
    }

    public function boot(): void
    {
    }
}
