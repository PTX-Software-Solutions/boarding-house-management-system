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
        Schema::create('nearby_attractions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('houseId')->nullable(false);
            $table->string('name');
            $table->integer('distance');
            $table->uuid('distanceTypeId')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('houseId')->references('id')->on('houses')->onDelete('cascade');
            $table->foreign('distanceTypeId')->references('id')->on('distance_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nearby_attractions');
    }
};
