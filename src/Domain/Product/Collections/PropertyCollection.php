<?php
declare(strict_types=1);

namespace Src\Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;
use Src\Domain\Product\Models\Property;
use Illuminate\Support\Collection as SupportCollection;

class PropertyCollection extends Collection
{
    /**
     * @return SupportCollection [property.title1 => [property.value, property.value...], property.title2 = [],]
     */
    public function titleToValue(): SupportCollection
    {
        return $this->mapWithKeys(function (Property $property) {
            return [$property->title => $property->pivot->value];
        });
    }
}
