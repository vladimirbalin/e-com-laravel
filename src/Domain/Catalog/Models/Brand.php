<?php

namespace Src\Domain\Catalog\Models;

use App\Traits\Model\HasThumbnail;
use App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Domain\Catalog\Observers\BrandObserver;
use Src\Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Src\Domain\Product\Models\Product;

#[ObservedBy(BrandObserver::class)]
class Brand extends Model
{
    use HasFactory;
    use Sluggable;
    use HasThumbnail;

    protected $guarded = [];

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function thumbnailDir(): string
    {
        return 'brands';
    }

    protected function hasSubfolder(): bool
    {
        return false;
    }
}
