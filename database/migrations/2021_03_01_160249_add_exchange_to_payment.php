<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExchangeToPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('received_payments', function (Blueprint $table) {
            $table->double('exchange_rate', 10, 5)->nullable();
            $table->string('exchange_rate_file')->nullable();
        });
        Schema::table('done_payments', function (Blueprint $table) {
            $table->double('exchange_rate', 10, 5)->nullable();
            $table->string('exchange_rate_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('received_payments', function (Blueprint $table) {
            //
        });
    }
}
