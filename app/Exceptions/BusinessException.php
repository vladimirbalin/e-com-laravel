<?php
declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class BusinessException extends RuntimeException
{
    public function __construct(private string $userMessage)
    {
        parent::__construct('Business exception');
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }
}
