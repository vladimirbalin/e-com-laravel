<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Domain\Order\Models\Order;
use Src\Domain\Order\Models\OrderItem;
use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Order::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedInteger('price');
            $table->unsignedMediumInteger('quantity');
        });

        Schema::create('order_item_option_value', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(OrderItem::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('order_items');
        }
    }
};
