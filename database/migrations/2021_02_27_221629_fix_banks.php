<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('date');
            $table->dropColumn('currency');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('details');
            $table->dropColumn('address');
            $table->dropColumn('notes');
        });
        Schema::table('banks', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('date')->nullable();
            $table->string('currency')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('details')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
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
