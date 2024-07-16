<?php
declare(strict_types=1);

namespace Src\Support\Exceptions;

use Exception;

class PriceValueNotAvailable extends Exception
{
    public static function mustNotBeLessThanZero(): self
    {
        return new self(__('exceptions.price_less_than_zero'));
    }
}
