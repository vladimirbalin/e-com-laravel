<?php

namespace Src\Domain\Product\Models;

use App\Casts\PriceCast;
use App\Observers\ProductObserver;
use App\Traits\Model\HasThumbnail;
use App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Screen\AsSource;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Catalog\Models\Category;
use Src\Domain\Product\QueryBuilders\ProductQueryBuilder;

#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFactory;
    use Sluggable;
    use HasThumbnail;
    use AsSource;

    protected $guarded = [];

    protected $casts = ['price' => PriceCast::class];

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
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
            ->withPivot('value');
    }

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    protected function hasSubfolder(): bool
    {
        return true;
    }

    public static function baseFolder(): string
    {
        return 'products/' . now()->format('Y-m-d');
    }
}
