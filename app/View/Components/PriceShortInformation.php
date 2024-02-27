<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Src\Support\ValueObjects\Price;

class PriceShortInformation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Price $price)
    {
        //
    }

    public function render()
    {
        return <<<'blade'
    {{ $price->getFormattedValueWithSymbol() }}
blade;
    }
}
