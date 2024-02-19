<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedSmallInteger('sorting')->default(999)->after('thumbnail');
            $table->boolean('is_on_the_main_page')->default(false)->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['sorting', 'is_on_the_main_page']);
        });
    }
};
