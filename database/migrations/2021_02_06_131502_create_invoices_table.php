<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_date');
            $table->string('from_date');
            $table->string('to_date');
            $table->integer('amount');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('invoices');
    }
}
