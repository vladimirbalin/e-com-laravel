<?php
declare(strict_types=1);

namespace Src\Support;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

class Transaction
{
    public static function run(
        Closure $callback,
        Closure $onSuccess = null,
        Closure $onError = null,
    ) {
        try {
            DB::beginTransaction();

            return tap($callback(), function ($callbackReturn) use ($onSuccess) {
                if (! is_null($onSuccess)) {
                    $onSuccess($callbackReturn);
                }

                DB::commit();
            });
        } catch (Throwable $e) {
            DB::rollBack();

            if (! is_null($onError)) {
                $onError($e);
            }

            throw $e;
        }
    }
}
