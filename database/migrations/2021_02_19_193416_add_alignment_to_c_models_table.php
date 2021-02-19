<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlignmentToCModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_models', function (Blueprint $table) {
            $table->string('item_code_alignment')->nullable();
            $table->string('description_alignment')->nullable();
            $table->string('quantity_alignment')->nullable();
            $table->string('price_alignment')->nullable();
            $table->string('amount_alignment')->nullable();
            $table->string('item_code_alignment_d')->nullable();
            $table->string('description_alignment_d')->nullable();
            $table->string('quantity_alignment_d')->nullable();
            $table->string('price_alignment_d')->nullable();
            $table->string('amount_alignment_d')->nullable();
            $table->string('footer_alignment')->nullable();
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
