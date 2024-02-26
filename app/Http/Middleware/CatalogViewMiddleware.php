<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CatalogViewMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($view = $request->get('view')) {
            $request->session()->put('catalog-view', $view);
        }

        return $next($request);
    }
}
