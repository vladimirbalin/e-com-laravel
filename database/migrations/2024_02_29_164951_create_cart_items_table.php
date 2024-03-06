<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Domain\Cart\Models\Cart;
use Src\Domain\Cart\Models\CartItem;
use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Cart::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedMediumInteger('quantity');
            $table->unsignedInteger('price');
            $table->string('string_option_values')->nullable();
        });

        Schema::create('cart_item_option_value', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(CartItem::class)
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
        Schema::dropIfExists('cart_items');
    }
};
