<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVInvoicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_invoics', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_date')->nullable();
            $table->string('from_date')->nullable();
            $table->string('inv_number')->nullable();
            $table->string('to_date')->nullable();
            $table->integer('amount')->nullable();
            $table->unsignedBigInteger('v_model_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
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
        Schema::dropIfExists('v_invoics');
    }
}
