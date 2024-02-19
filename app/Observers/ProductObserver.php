<?php

namespace App\Observers;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Product\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        //
    }

    public function updated(Product $product): void
    {
        //
    }

    public function deleted(Product $product): void
    {
        $thumbnailFullPathWithFilename = str($product->thumbnail)
            ->ltrim('/storage')
            ->value();

        if (Storage::fileExists($thumbnailFullPathWithFilename)) {
            Storage::delete($thumbnailFullPathWithFilename);
        }
    }

    public function restored(Product $product): void
    {
        //
    }

    public function forceDeleted(Product $product): void
    {
        //
    }
}
