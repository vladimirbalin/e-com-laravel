<?php
declare(strict_types=1);

namespace Src\Support;

use App\Events\SessionRegeneratedEvent;
use Closure;

class SessionRegenerateAction
{
    public static function handle(Closure $callback = null)
    {
        $oldId = request()->session()->getId();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if (! is_null($callback)) {
            $callback();
        }

        event(new SessionRegeneratedEvent($oldId, request()->session()->getId()));
    }
}
