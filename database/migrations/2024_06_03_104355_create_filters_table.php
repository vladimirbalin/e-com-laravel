<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('namespace');
        });
    }

    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('filters');
        }
    }
};
