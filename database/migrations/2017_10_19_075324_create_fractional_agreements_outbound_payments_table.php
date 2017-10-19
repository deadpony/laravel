<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFractionalAgreementsOutboundPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fractional_agreements_outbound_payments', function (Blueprint $table) {
            $table->string('fractional_agreement_id', 36);
            $table->foreign('fractional_agreement_id', 'faop_fa')->references('id')->on('fractional_agreements')->onDelete('cascade');

            $table->string('outbound_payment_id', 36)->unique('faow_outbound_payment_id_unique');
            $table->foreign('outbound_payment_id', 'faop_ip')->references('id')->on('outbound_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fractional_agreements_outbound_payments');
    }
}
