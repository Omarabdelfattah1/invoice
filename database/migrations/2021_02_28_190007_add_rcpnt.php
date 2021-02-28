<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRcpnt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('received_payments', function (Blueprint $table) {
            $table->string('rcpnt')->nullable();
        });
        Schema::table('done_payments', function (Blueprint $table) {
            $table->string('rcpnt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('received_payment', function (Blueprint $table) {
            //
        });
    }
}
