<?php

namespace Src\Domain\Product\Models;

use App\Casts\PriceCast;
use App\Observers\ProductObserver;
use App\Traits\Model\HasThumbnail;
use App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Product\Collections\ProductCollection;
use Src\Domain\Product\QueryBuilders\ProductQueryBuilder;


#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFactory;
    use Sluggable;
    use HasThumbnail;

    protected $guarded = [];

    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public function newCollection(array $models = []): ProductCollection
    {
        return new ProductCollection($models);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withTimestamps()
            ->withPivot(['id', 'value']);
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    protected function hasSubfolder(): bool
    {
        return true;
    }

    protected function jsonPropertiesGet(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $this->json_properties ?? $this->properties->titleToValue(),
            set: fn ($value) => $value,
        );
    }
}
