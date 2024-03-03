<?php
declare(strict_types=1);

namespace Src\Support\ValueObjects;

use App\Traits\Makeable;
use Src\Support\Exceptions\CurrencyNotAllowed;
use Src\Support\Exceptions\PriceMustNotBeLessThanZero;
use Stringable;

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    /**
     * @param int $value in minor units
     * @param string $currency
     * @param int $precision
     * @throws CurrencyNotAllowed
     * @throws PriceMustNotBeLessThanZero
     */
    public function __construct(
        private int             $value,
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
     * Get value in "minor" units (cents, kopeiki)
     * Raw value
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Value in "major" units
     * Dividing raw value by precision
     */
    public function getPreparedValue(): float|int
    {
        return $this->value / $this->precision;
    }

    /**
     * Get value part. "Viewable/readable" price string
     * @return string
     */
    public function getFormattedValue(): string
    {
        return number_format($this->getPreparedValue(), 2, '.', ' ');
    }

    /**
     * Get value and currency symbol parts. "Viewable/readable" price string
     * @return string
     */
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

    public function multiplyBy(int $multiplier): static
    {
        $this->value *= $multiplier;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFormattedValueWithSymbol();
    }
}
