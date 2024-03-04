<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Domain\Auth\Models\User;
use Src\Domain\Order\Models\DeliveryMethod;
use Src\Domain\Order\Models\PaymentMethod;
use Src\Domain\Order\OrderStatusEnum;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(DeliveryMethod::class)
                ->constrained();
            $table->foreignIdFor(PaymentMethod::class)
                ->constrained();
            $table->string('status')->default(OrderStatusEnum::NEW->value);
            $table->unsignedInteger('total')->default(0);
        });
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('orders');
        }
    }
};
