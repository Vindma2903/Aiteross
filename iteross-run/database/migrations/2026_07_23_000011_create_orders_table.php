<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable()->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->unsignedInteger('product_price');
            $table->string('product_unit_mode', 20);
            $table->unsignedInteger('product_unit_multiplier')->default(1);
            $table->unsignedInteger('quantity');
            $table->string('status', 20);
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
