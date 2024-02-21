<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Observers;

use Illuminate\Support\Facades\Cache;
use Src\Domain\Catalog\Models\Category;

class CategoryObserver
{
    private function forget(): void
    {
        Cache::forget('categories_main_page');
        Cache::forget('categories_catalog_page');
    }

    public function saved(Category $category): void
    {
        $this->forget();
    }

    public function deleted(Category $category): void
    {
        $this->forget();
    }

    public function restored(Category $category): void
    {
        $this->forget();
    }

    public function forceDeleted(Category $category): void
    {
        $this->forget();
    }
}
