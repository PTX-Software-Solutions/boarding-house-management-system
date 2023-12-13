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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->decimal('monthlyDeposit', 9, 2);
            $table->uuid('houseId')->nullable(false);
            $table->uuid('roomTypeId')->nullable(false);
            $table->uuid('statusId')->nullable(false);
            $table->foreign('houseId')->references('id')->on('houses')->onDelete('cascade');
            $table->foreign('roomTypeId')->references('id')->on('room_types')->onDelete('cascade');
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
        Schema::dropIfExists('rooms');
    }
};
