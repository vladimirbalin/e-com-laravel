<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->boolean('redirect_to_pay')->default(false);
        });

        \Illuminate\Support\Facades\DB::table('payment_methods')->insert(['title' => 'Наличные']);
        \Illuminate\Support\Facades\DB::table('payment_methods')->insert(['title' => 'Онлайн', 'redirect_to_pay' => true]);
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('payment_methods');
        }
    }
};
