<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditModelTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_models', function (Blueprint $table) {
            $table->dropColumn('invoice_title');
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->dropColumn('invoice_title');
        });
        Schema::table('c_models', function (Blueprint $table) {
            $table->text('invoice_title')->nullable();
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->text('invoice_title')->nullable();
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
