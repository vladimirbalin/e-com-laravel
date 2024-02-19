<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Collections;

use Illuminate\Database\Eloquent\Collection;

class CategoryCollection extends Collection
{
    public function alphabet(): CategoryCollection
    {
        return $this->sortBy('title');
    }
}
