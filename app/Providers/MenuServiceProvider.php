<?php
declare(strict_types=1);

namespace App\Providers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('menu', new Menu(
                new MenuItem('Главная', route('home')),
                new MenuItem('Каталог', route('catalog.index')),
            ));
        });
    }
}
