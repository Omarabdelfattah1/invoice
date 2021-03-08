<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SpaceUnderDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_models', function (Blueprint $table) {
            $table->integer('sp_date_heading')->nullable();
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->integer('sp_date_heading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_models', function (Blueprint $table) {
            //
        });
    }
}
