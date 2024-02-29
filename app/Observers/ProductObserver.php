<?php

namespace App\Observers;

use App\Jobs\SavePropertiesForProductJob;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Product\Models\Product;

class ProductObserver
{
    public function created(Product $product)
    {
        SavePropertiesForProductJob::dispatch($product)->delay(CarbonInterval::seconds(10));
    }
    public function saved(Product $product): void
    {
        $this->forget();
//        if (! $this->changedOnlyJsonProperties($product)) {
//            SavePropertiesForProductJob::dispatch($product)->delay(CarbonInterval::seconds(10));
//        }
    }

    private function changedOnlyJsonProperties(Product $product): bool
    {
        return (count($product->getDirty()) === 1 &&
            $product->isDirty('json_properties'));
    }

    public function deleted(Product $product): void
    {
        $thumbnailFullPathWithFilename = str($product->thumbnail)
            ->ltrim('/storage')
            ->value();

        if (Storage::fileExists($thumbnailFullPathWithFilename)) {
            Storage::delete($thumbnailFullPathWithFilename);
        }

        $this->forget();
    }

    public function restored(Product $product): void
    {
        $this->forget();
    }

    public function forceDeleted(Product $product): void
    {
        $this->forget();
    }

    private function forget(): void
    {
        Cache::forget('max_product_price');
        Cache::forget('product_main_page');
        Cache::forget('product_catalog_page');
    }
}
