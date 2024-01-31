<?php

namespace App\Models;

use App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
