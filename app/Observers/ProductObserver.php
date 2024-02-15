<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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
