<?php

namespace Src\Domain\Catalog\Models;

use App\Models\Product;
use App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\Domain\Catalog\Collections\CategoryCollection;
use Src\Domain\Catalog\Observers\CategoryObserver;
use Src\Domain\Catalog\QueryBuilders\CategoryQueryBuilder;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    public function newCollection(array $models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
