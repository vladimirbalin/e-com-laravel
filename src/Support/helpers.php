<?php
declare(strict_types=1);

use Src\Support\Flash\Flash;

if (! function_exists('flash')) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
