<?php
declare(strict_types=1);

namespace Src\Support\Exceptions;

use Exception;
use Throwable;

class CurrencyNotAllowed extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = __('exceptions.currency_not_allowed');
    }
}
