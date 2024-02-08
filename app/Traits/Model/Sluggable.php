<?php

namespace App\Traits\Model;


use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    protected static function bootSluggable(): void
    {
        static::creating(function (Model $model) {
            $model->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        $slugFrom = $this->slugFrom();
        $slug = str($this->{$slugFrom})
            ->slug()
            ->value();

        $this->{$this->slugColumn()} = $this->makeUniqueSlug($slug);
    }

    protected function makeUniqueSlug(string $slug): string
    {
        $assumptiveSlug = $slug;
        $counter = 1;

        while ($this->alreadyHasSlug($assumptiveSlug)) {
            $assumptiveSlug = $slug . '-' . $counter;
            $counter++;
        }

        return $assumptiveSlug;
    }

    protected function alreadyHasSlug(string $slug): bool
    {
        return static::newQuery()
            ->where($this->slugColumn(), $slug)
            ->withoutGlobalScopes()
            ->exists();
    }

    protected static function slugFrom(): string
    {
        return 'title';
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }
}
