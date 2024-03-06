<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Domain\Order\Models\Order;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Order::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
        });
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('order_informations');
        }
    }
};
