<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaypalPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('received_payments', function (Blueprint $table) {
            $table->string('paid_by')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('transction_id')->nullable();
            $table->text('details')->nullable();
        });
        Schema::table('done_payments', function (Blueprint $table) {
            $table->string('paid_by')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('transction_id')->nullable();
            $table->text('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
