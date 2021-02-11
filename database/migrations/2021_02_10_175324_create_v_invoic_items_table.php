<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVInvoicItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_invoic_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('price');
            $table->unsignedBigInteger('v_invoic_id');
            $table->unsignedBigInteger('v_item_id');
            $table->foreign('v_invoic_id')->references('id')->on('v_invoics');
            $table->foreign('v_item_id')->references('id')->on('v_items');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_invoic_items');
    }
}
