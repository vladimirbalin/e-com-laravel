<?php

namespace App\Traits\Model;


use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    private static int $counter = 1;

    protected static function bootSluggable(): void
    {
        static::creating(function (Model $model) {
            $assumptiveSlug = $model->slug ?? str($model->{self::slugFrom()})->slug();
            while (static::alreadyHasSlug($assumptiveSlug)) {
                $assumptiveSlug = $assumptiveSlug . '-' . static::$counter;
                static::$counter++;
            }

            $model->slug = $assumptiveSlug;
        });
    }

    protected static function alreadyHasSlug(string $slug): bool
    {
        return static::query()->where('slug', $slug)->exists();
    }

    protected static function slugFrom(): string
    {
        return 'title';
    }
}
