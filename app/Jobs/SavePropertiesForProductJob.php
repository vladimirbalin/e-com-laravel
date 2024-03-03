<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Domain\Product\Models\Product;

class SavePropertiesForProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Product $product)
    {
        //
    }

    public function handle(): void
    {
        $jsonProperties = $this->product->properties->titleToValue();
        $this->product->update(['json_properties' => $jsonProperties]);
    }
}
