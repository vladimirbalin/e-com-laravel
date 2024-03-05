<?php
declare(strict_types=1);

namespace Src\Domain\Order\Contracts;

use Closure;
use Src\Domain\Order\Models\Order;

interface OrderProcessPipe
{
    public function handle(Order $order, Closure $next);
}
