<?php
declare(strict_types=1);

namespace Src\Domain\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\Domain\Product\Collections\PropertyCollection;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withTimestamps()
            ->withPivot('value');
    }

    public function newCollection(array $models = []): PropertyCollection
    {
        return new PropertyCollection($models);
    }
}
