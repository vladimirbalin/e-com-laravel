<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Seo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $seo = Cache::rememberForever($this->cacheKey($request), function () use ($request) {
            return Seo::where('url', $request->getPathInfo())->first(['url', 'title']);
        });

        if ($seo) {
            view()->share('seo_title', $seo->title);
        }

        return $next($request);
    }

    private function cacheKey($request): string
    {
        return 'seo_' . $request->getPathInfo();
    }
}
