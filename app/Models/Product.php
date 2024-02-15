<?php

namespace App\Models;

use App\Observers\ProductObserver;
use App\Traits\Model\HasThumbnail;
use App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Number;

#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFactory;
    use Sluggable;
    use HasThumbnail;

    protected $fillable = [
        'title',
        'slug',
        'price',
        'thumbnail',
        'brand_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeForMainPage(Builder $query): Builder
    {
        return $query->where('is_on_the_main_page', true);
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    protected function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => Number::currency($attributes['price'] / 100, 'RUB', 'ru'),
        );
    }
}
