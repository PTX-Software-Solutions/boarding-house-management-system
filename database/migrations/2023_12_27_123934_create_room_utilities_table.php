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
        Schema::create('room_utilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('roomId')->nullable(false);
            $table->uuid('roomUtilityType')->nullable(false);
            $table->uuid('roomUtilityScope')->nullable(false);
            $table->decimal('price', 9, 2)->nullable();
            $table->foreign('roomId')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('roomUtilityType')->references('id')->on('room_utility_types')->onDelete('cascade');
            $table->foreign('roomUtilityScope')->references('id')->on('room_utility_scopes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_utilities');
    }
};
