<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentStatementsTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_statements_terms', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('statement_id', 36)->unique();
            $table->foreign('statement_id')->references('id')->on('installment_statements')->onDelete('cascade');
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
        Schema::dropIfExists('installment_statements_terms');
    }
}
