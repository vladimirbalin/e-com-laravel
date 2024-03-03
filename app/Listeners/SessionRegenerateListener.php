<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\SessionRegeneratedEvent;
use Src\Domain\Cart\CartManager;

class SessionRegenerateListener
{
    public function __construct()
    {
    }

    public function handle(SessionRegeneratedEvent $event): void
    {
        app(CartManager::class)->updateId($event->oldId, $event->currentId);
    }
}
