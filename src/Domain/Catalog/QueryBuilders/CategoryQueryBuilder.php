<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{
    public function forMainPage(): Builder
    {
        return $this->where('is_on_the_main_page', true);
    }

    public function whereCategoryId(int $categoryId): Builder
    {
        return $this->where('categories.id', $categoryId);
    }
}
