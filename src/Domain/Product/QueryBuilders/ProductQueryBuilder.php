<?php
declare(strict_types=1);

namespace Src\Domain\Product\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function forMainPage(): Builder
    {
        return $this->where('is_on_the_main_page', true);
    }
}
