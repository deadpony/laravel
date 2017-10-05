<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingStatementsTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_statements_terms', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('statement_id', 36)->unique();
            $table->foreign('statement_id')->references('id')->on('incoming_statements')->onDelete('cascade');
            $table->tinyInteger('months');
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
        Schema::dropIfExists('incoming_statements_terms');
    }
}
