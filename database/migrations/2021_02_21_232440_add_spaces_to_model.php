<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpacesToModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payment_r_s');
        Schema::dropIfExists('payment_p_s');
        Schema::dropIfExists('receive_items');
        Schema::dropIfExists('payment_items');   
        Schema::table('c_models', function (Blueprint $table) {
            $table->integer('sp_note_top')->nulable();
        });
        Schema::table('v_models', function (Blueprint $table) {
            $table->integer('sp_note_top')->nulable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
