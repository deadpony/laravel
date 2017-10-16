<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFractionalAgreementsTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fractional_agreements_terms', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('agreement_id', 36)->unique();
            $table->foreign('agreement_id')->references('id')->on('fractional_agreements')->onDelete('cascade');
            $table->tinyInteger('months');
            $table->float('setup_fee', 8,2);
            $table->float('monthly_fee', 8,2);
            $table->tinyInteger('deadline_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fractional_agreements_terms');
    }
}
