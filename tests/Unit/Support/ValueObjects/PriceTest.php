<?php
declare(strict_types=1);

namespace Tests\Unit\Support\ValueObjects;

use Src\Support\Exceptions\CurrencyNotAllowed;
use Src\Support\Exceptions\PriceValueNotAvailable;
use Src\Support\ValueObjects\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{
    public function test_create_value_object_success()
    {
        $raw = 25000;
        $valueObject = new Price($raw);

        $this->assertIsInt($valueObject->getValue());
        $this->assertIsString($valueObject->getCurrency());

        $this->assertEquals($raw / 100, $valueObject->getPreparedValue());
        $this->assertEquals($raw, $valueObject->getValue());
        $this->assertEquals('RUB', $valueObject->getCurrency());
        $this->assertEquals('₽', $valueObject->getSymbol());
        $this->assertInstanceOf(Price::class, $valueObject);
    }

    public function test_currency_invalid()
    {
        $this->expectException(CurrencyNotAllowed::class);
        $this->expectExceptionMessage(__('exceptions.currency_not_allowed'));

        $unavailableCurrency = 'BTN';
        new Price(25000, $unavailableCurrency);
    }

    public function test_less_than_zero_values()
    {
        $this->expectException(PriceValueNotAvailable::class);
        $this->expectExceptionMessage(__('exceptions.price_less_than_zero'));

        new Price(-25000);
    }
}
