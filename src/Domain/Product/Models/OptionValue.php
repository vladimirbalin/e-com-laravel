<?php
declare(strict_types=1);

namespace Src\Domain\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\Domain\Product\Collections\OptionValueCollection;

class OptionValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function newCollection(array $models = []): OptionValueCollection
    {
        return new OptionValueCollection($models);
    }
}
