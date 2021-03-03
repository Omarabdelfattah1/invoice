<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReceivedPaymentInvoiceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('received_payments', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn('invoice_id');
        });
        Schema::table('received_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
        });
        Schema::table('done_payments', function (Blueprint $table) {
            $table->dropForeign(['v_invoic_id']);
            $table->dropColumn('v_invoic_id');
        });
        Schema::table('done_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('v_invoic_id')->nullable();
            $table->foreign('v_invoic_id')->references('id')->on('v_invoics')->onDelete('set null');
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
