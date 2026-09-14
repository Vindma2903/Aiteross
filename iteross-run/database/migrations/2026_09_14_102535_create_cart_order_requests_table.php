<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_order_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 50);
            $table->string('email')->nullable();
            $table->text('comment')->nullable();
            $table->json('items');
            $table->unsignedInteger('total_quantity');
            $table->unsignedInteger('total_price')->default(0);
            $table->boolean('has_unknown_price')->default(false);
            $table->string('status', 20)->default('new');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_order_requests');
    }
};
