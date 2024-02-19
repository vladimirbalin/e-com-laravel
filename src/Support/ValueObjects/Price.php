<?php
declare(strict_types=1);

namespace Src\Support\ValueObjects;

use Src\Support\Exceptions\CurrencyNotAllowed;
use Src\Support\Exceptions\PriceMustNotBeLessThanZero;
use Stringable;

class Price implements Stringable
{
    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        private readonly int    $value,
        private readonly string $currency = 'RUB',
        private readonly int    $precision = 100
    ) {
        if ($value < 0) {
            throw new PriceMustNotBeLessThanZero();
        }

        if (! isset($this->currencies[$this->currency])) {
            throw new CurrencyNotAllowed();
        }
    }

    /**
     * Get value in minor units (cents, kopeiki)
     * Raw value
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Get calculated price (Not in "minor units")
     * Dividing raw value by precision
     * @return float|int
     */
    public function getPreparedValue(): float|int
    {
        return $this->value / $this->precision;
    }

    public function getFormattedValue(): string
    {
        return number_format($this->getPreparedValue(), 2, '.', ' ');
    }

    public function getFormattedValueWithSymbol(): string
    {
        return $this->getFormattedValue() . ' ' . $this->getSymbol();
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getSymbol()
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return $this->getFormattedValueWithSymbol();
    }
}
