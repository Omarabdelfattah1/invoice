<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('done_payments', function (Blueprint $table) {
            $table->id();
            $table->text('notes');
            $table->string('payment_type')->nullable();
            $table->string('payment_date')->nullable();
            $table->double('amount_paid', 10, 5)->nullable();
            $table->unsignedBigInteger('v_invoic_id');
            $table->foreign('v_invoic_id')->references('id')->on('v_invoics');
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('done_payments');
    }
}
