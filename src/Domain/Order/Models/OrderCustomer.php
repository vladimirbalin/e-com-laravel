<?php
declare(strict_types=1);

namespace Src\Domain\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    use HasFactory;

    protected $guarded = [];
}
