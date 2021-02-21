<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('v_invoics', function (Blueprint $table) {
            $table->dropColumn('invoice_date');
            $table->dropColumn('from_date');
            $table->dropColumn('inv_number');
            $table->dropColumn('to_date');
            $table->dropColumn('amount');
        });
        Schema::table('v_invoics', function (Blueprint $table) {
            $table->string('invoice_date')->nullable();
            $table->string('from_date')->nullable();
            $table->string('inv_number')->nullable();
            $table->string('to_date')->nullable();
            $table->integer('amount')->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_date');
            $table->dropColumn('from_date');
            $table->dropColumn('inv_number');
            $table->dropColumn('to_date');
            $table->dropColumn('amount');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_date')->nullable();
            $table->string('from_date')->nullable();
            $table->string('inv_number')->nullable();
            $table->string('to_date')->nullable();
            $table->integer('amount')->nullable();
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
