<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFractionalAgreementsOutboundWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fractional_agreements_outbound_wallet', function (Blueprint $table) {
            $table->string('fractional_agreement_id', 36);
            $table->foreign('fractional_agreement_id', 'faow_fa')->references('id')->on('fractional_agreements')->onDelete('cascade');

            $table->string('outbound_wallet_id', 36)->unique('faow_outbound_wallet_id_unique');
            $table->foreign('outbound_wallet_id', 'faow_iw')->references('id')->on('outbound_wallet')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fractional_agreements_outbound_wallet');
    }
}
