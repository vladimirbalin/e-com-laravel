<?php
declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class SessionRegeneratedEvent
{
    use Dispatchable;

    public function __construct(
        public string $oldId,
        public string $currentId,
    )
    {
    }

}
