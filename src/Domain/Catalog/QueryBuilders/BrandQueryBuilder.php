<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class BrandQueryBuilder extends Builder
{
    public function forMainPage(): Builder
    {
        return $this->where('is_on_the_main_page', true);
    }
}
