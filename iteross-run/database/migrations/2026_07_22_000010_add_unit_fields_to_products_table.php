<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit_mode', 16)->default('pieces')->after('stock_quantity');
            $table->unsignedInteger('unit_multiplier')->default(1)->after('unit_mode');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit_mode', 'unit_multiplier']);
        });
    }
};
