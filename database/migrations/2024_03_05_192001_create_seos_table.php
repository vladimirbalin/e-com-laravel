<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('url')->unique();
            $table->string('title');
        });

        $routes = collect(Route::getRoutes())->map(function ($route) {
            $url = ! str($route->uri())->startsWith('/')
                ? '/' . $route->uri()
                : $route->uri();

            return ['title' => $route->getName(), 'url' => $url];
        })
            ->filter(fn ($item) => isset($item['url'], $item['title']))
            ->unique('url')
            ->toArray();
        \Illuminate\Support\Facades\DB::table('seos')->insert($routes);
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('seos');
        }
    }
};
