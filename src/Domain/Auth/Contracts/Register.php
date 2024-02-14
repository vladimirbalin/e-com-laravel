<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Contracts;

use Src\Domain\Auth\DTO\RegisterDto;

interface Register
{
    public function __invoke(RegisterDto $dto): void;
}
