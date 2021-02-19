<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalAlignmentForCModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_models', function (Blueprint $table) {
            $table->string('wtotal_alignment')->nullable();
            $table->string('total_alignment')->nullable();
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->string('wtotal_alignment')->nullable();
            $table->string('total_alignment')->nullable();
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
