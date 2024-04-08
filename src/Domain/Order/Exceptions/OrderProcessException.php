<?php

declare(strict_types=1);

namespace Src\Domain\Order\Exceptions;

use Exception;
use Throwable;

class OrderProcessException extends Exception
{

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        if (! app()->isProduction()) {
            $this->message .= PHP_EOL . 'Method: ' . __METHOD__ . ', file: ' . $this->getFile() . ', line: ' . $this->getLine() . '\n';
        }
    }
}
