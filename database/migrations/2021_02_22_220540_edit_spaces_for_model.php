<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditSpacesForModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_models', function (Blueprint $table) {
            $table->dropColumn('sp_note_top');
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->dropColumn('sp_note_top');
        });
        Schema::table('c_models', function (Blueprint $table) {
            $table->integer('sp_note_top')->nullable();
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->integer('sp_note_top')->nullable();
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
