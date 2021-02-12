<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditItemRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table)
        {
            $table->dropColumn('rate');
        });
        Schema::table('items', function (Blueprint $table)
        {
            $table->double('rate', 10, 5);
        });
        Schema::table('v_invoic_items', function (Blueprint $table)
        {
            $table->dropColumn('price');
        });
        Schema::table('v_invoic_items', function (Blueprint $table)
        {
            $table->double('price', 10, 5);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table)
        {
            $table->dropColumn('rate');
        });
        Schema::table('v_invoic_items', function (Blueprint $table)
        {
            $table->dropColumn('price');

        });
    }
}
