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
        Schema::create('ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('houseId')->nullable(false);
            $table->uuid('reservationId')->nullable(false);
            $table->uuid('userId')->nullable(false);
            $table->smallInteger('rating');
            $table->foreign('houseId')->references('id')->on('houses')->onDelete('cascade');
            $table->foreign('reservationId')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
