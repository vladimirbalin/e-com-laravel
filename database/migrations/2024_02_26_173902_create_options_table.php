<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Domain\Product\Models\Option;
use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
        });

        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Option::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('title');
        });

        Schema::create('option_value_product', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('option_value_product');
    }
};
