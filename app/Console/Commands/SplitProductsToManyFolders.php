<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Product\Models\Product;

class SplitProductsToManyFolders extends Command
{
    protected $signature = 'app:split-products-to-many-folders';

    protected $description = 'Move through all product images in one folder and move them to different, with Y-m-d names';

    public function handle(): void
    {
        $today = Carbon::today();

        Product::chunk(5, function (Collection $products) use (&$today) {
            $newSubFolderName = $today->format('Y-m-d');

            $storage = Storage::disk('images');

            if (! $storage->exists('products/' . $newSubFolderName)) {
                $storage->makeDirectory('products/' . $newSubFolderName);
            }

            foreach ($products as $product) {
                $file = File::basename($product->thumbnail);
                $storage->move('products/' . $file, 'products/' . $newSubFolderName . '/' . $file);
                $product->thumbnail = '/storage/' . trim($newSubFolderName, '/') . "/$file";
                $product->save();
            }

            $today = $today->subDay();
        });
    }
}
