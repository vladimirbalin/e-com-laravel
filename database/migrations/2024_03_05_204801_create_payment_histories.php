<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('payment_gateway');
            $table->string('method')->nullable();
            $table->json('payload')->nullable();
        });
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('payment_histories');
        }
    }
};
