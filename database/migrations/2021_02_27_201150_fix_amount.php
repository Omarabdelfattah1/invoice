<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v_invoics', function (Blueprint $table) {
            
            $table->dropColumn('amount');
        });
        Schema::table('v_invoics', function (Blueprint $table) {
            
            $table->double('amount', 10, 5)->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            
            $table->dropColumn('amount');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->double('amount', 10, 5)->nullable();
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
