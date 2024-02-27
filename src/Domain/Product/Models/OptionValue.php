<?php
declare(strict_types=1);

namespace Src\Domain\Product\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Screen\AsSource;

class OptionValue extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = ['title'];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    protected function full(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => "{$this->option->title}: " . $attributes['title'],
        );
    }
}
