<?php
declare(strict_types=1);

namespace Src\Domain\Catalog\Observers;

use Illuminate\Support\Facades\Cache;
use Src\Domain\Catalog\Models\Brand;

class BrandObserver
{
    private function forget(): void
    {
        Cache::forget('brands_main_page');
        Cache::forget('brands_catalog_page');
    }

    public function saved(Brand $brand): void
    {
        $this->forget();
    }

    public function deleted(Brand $brand): void
    {
        $this->forget();
    }

    public function restored(Brand $brand): void
    {
        $this->forget();
    }

    public function forceDeleted(Brand $brand): void
    {
        $this->forget();
    }
}
