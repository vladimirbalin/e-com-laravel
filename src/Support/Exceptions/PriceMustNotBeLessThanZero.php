<?php
declare(strict_types=1);

namespace Src\Support\Exceptions;

use Exception;
use Throwable;

class PriceMustNotBeLessThanZero extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = __('exceptions.price_less_than_zero');
    }
}
