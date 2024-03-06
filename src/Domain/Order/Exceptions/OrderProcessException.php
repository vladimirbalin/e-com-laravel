<?php
declare(strict_types=1);

namespace Src\Domain\Order\Exceptions;

use DomainException;
use Exception;

class OrderProcessException extends DomainException
{

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        if (! app()->isProduction()) {
            $this->message .= "\n Method: " . __METHOD__ . ", file: " . $this->getFile() . ", line: " . $this->getLine() . "\n";
        }
    }
}
