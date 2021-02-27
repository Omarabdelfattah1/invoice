<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPaymenNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('received_payments', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
        Schema::table('done_payments', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
        Schema::table('received_payments', function (Blueprint $table) {
            $table->text('notes')->nullable();
        });
        Schema::table('done_payments', function (Blueprint $table) {
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
        Schema::table('received_payments', function (Blueprint $table) {
            //
        });
    }
}
