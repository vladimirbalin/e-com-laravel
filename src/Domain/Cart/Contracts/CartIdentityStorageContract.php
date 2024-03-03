<?php
declare(strict_types=1);

namespace Src\Domain\Cart\Contracts;

interface CartIdentityStorageContract
{
    public function get(): string;
}
