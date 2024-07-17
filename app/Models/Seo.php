<?php
declare(strict_types=1);

namespace App\Models;

use App\Casts\SeoUrlCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Seo extends Model
{
    protected $fillable = ['title', 'url'];

    protected $casts = ['url' => SeoUrlCast::class];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Seo $seo) {
            Cache::forget('seo_' . str($seo->url)->slug('_'));
        });

        static::deleted(function (Seo $seo) {
            Cache::forget('seo_' . str($seo->url)->slug('_'));
        });
    }
}
