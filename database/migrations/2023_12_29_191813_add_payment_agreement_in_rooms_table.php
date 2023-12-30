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
        Schema::table('rooms', function (Blueprint $table) {
            $table->uuid('paymentAgreementId')->nullable(false)->after('roomTypeId');
            $table->foreign('paymentAgreementId')->references('id')->on('payment_agreement_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign('rooms_paymentAgreementId_foreign');
            $table->dropColumn('paymentAgreementId');
        });
    }
};
