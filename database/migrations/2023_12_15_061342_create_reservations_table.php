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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('userId')->nullable(false);
            $table->uuid('houseId')->nullable(false);
            $table->uuid('roomId')->nullable(false);
            $table->uuid('statusId')->nullable(false);
            $table->timestamp('checkIn');
            $table->timestamp('checkOut')->nullable();
            $table->longText('note');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('houseId')->references('id')->on('houses')->onDelete('cascade');
            $table->foreign('roomId')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('statusId')->references('id')->on('statuses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
