<?php

declare(strict_types=1);

namespace Src\Domain\Order\Traits;

use Closure;

trait PaymentsEvents
{
    public static Closure $onSuccess;
    public static Closure $onCreating;
    public static Closure $onError;
    public static Closure $onValidating;

    public static function onSuccess(Closure $callable): void
    {
        self::$onSuccess = $callable;
    }

    public static function onCreating(Closure $callable): void
    {
        self::$onCreating = $callable;
    }

    public static function onError(Closure $callable): void
    {
        self::$onError = $callable;
    }

    public static function onValidating(Closure $callable): void
    {
        self::$onValidating = $callable;
    }
}
