<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payment_r_s');
        Schema::create('payment_r_s', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->float('amount')->nullable();
            $table->float('extra')->nullable();
            $table->float('xamount')->nullable();
            $table->string('currency')->nullable();
            $table->string('pdate')->nullable();
            $table->integer('exchange')->nullable();
            
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->timestamps();
        });
        Schema::dropIfExists('payment_p_s');
        Schema::create('payment_p_s', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('comment')->nullable();
            $table->float('amount')->nullable();
            $table->float('extra')->nullable();
            $table->float('xamount')->nullable();
            $table->string('currency')->nullable();
            $table->string('pdate')->nullable();
            $table->integer('exchange')->nullable();
            
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
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
        Schema::dropIfExists('payment_r_s');
        Schema::dropIfExists('payment_p_s');
        
    }
}
