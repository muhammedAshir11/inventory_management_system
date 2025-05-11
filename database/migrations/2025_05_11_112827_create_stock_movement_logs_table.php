<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_movement_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_movement_id');
            $table->json('data');
            $table->timestamps();
            $table->foreign('stock_movement_id')->references('id')->on('stock_movements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movement_logs');
    }
};
