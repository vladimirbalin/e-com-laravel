<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->unsignedInteger('price')->default(0);
            $table->boolean('with_address')->default(false);
        });

        \Illuminate\Support\Facades\DB::table('delivery_methods')->insert(['title' => 'Самовывоз']);
        \Illuminate\Support\Facades\DB::table('delivery_methods')->insert(['title' => 'Курьером', 'with_address' => true]);
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('delivery_methods');
        }
    }
};
