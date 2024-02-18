<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Contracts;

use Src\Domain\Auth\DTOs\RegisterDto;

interface Register
{
    public function handle(RegisterDto $dto): void;
}
