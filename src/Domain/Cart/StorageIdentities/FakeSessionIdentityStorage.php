<?php
declare(strict_types=1);

namespace Src\Domain\Cart\StorageIdentities;

use Src\Domain\Cart\Contracts\CartIdentityStorageContract;

class FakeSessionIdentityStorage implements CartIdentityStorageContract
{
    #[\Override] public function get(): string
    {
        return 'tests';
    }
}
