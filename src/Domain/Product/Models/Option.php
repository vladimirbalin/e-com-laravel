<?php
declare(strict_types=1);

namespace Src\Domain\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class Option extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = ['title'];

    public function optionValues(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }
}
