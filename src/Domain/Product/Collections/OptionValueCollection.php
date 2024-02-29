<?php
declare(strict_types=1);

namespace Src\Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Src\Domain\Product\Models\OptionValue;

class OptionValueCollection extends Collection
{
    public function keyValues(): SupportCollection
    {
        return $this->mapToGroups(function (OptionValue $optionValue) {
            return [$optionValue->option->title => $optionValue];
        });
    }
}
