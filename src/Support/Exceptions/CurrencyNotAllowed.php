<?php
declare(strict_types=1);

namespace Src\Support\Exceptions;

use Exception;

class CurrencyNotAllowed extends Exception
{
    public static function notInListOfAvailableCurrencies(): CurrencyNotAllowed
    {
        return new self(__('exceptions.currency_not_in_list_of_supported_currencies'));
    }
}
