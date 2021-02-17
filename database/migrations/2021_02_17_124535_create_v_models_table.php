<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('v_models');
        Schema::create('v_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('invoice_title')->nullable();
            $table->boolean('c_name_v')->nullable();
            $table->boolean('c_address_v')->nullable();
            $table->boolean('c_tel_v')->nullable();
            $table->boolean('c_country_v')->nullable();
            $table->boolean('c_email_v')->nullable();
            $table->boolean('cl_name_v')->nullable();
            $table->boolean('cl_address_v')->nullable();
            $table->boolean('cl_tel_v')->nullable();
            $table->boolean('cl_country_v')->nullable();
            $table->boolean('cl_email_v')->nullable();
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
            $table->boolean('from_date_v')->nullable();
            $table->boolean('to_date_v')->nullable();
            $table->integer('title_sp')->nullable();
            $table->text('text1')->nullable();
            $table->boolean('text1_v')->nullable();
            $table->text('note1')->nullable();
            $table->text('note2')->nullable();
            $table->text('note3')->nullable();
            $table->text('note4')->nullable();
            $table->boolean('note1_v')->nullable();
            $table->boolean('note2_v')->nullable();
            $table->boolean('note3_v')->nullable();
            $table->boolean('note4_v')->nullable();
            $table->integer('pdf_mr')->nullable();
            $table->integer('pdf_ml')->nullable();
            $table->integer('pdf_mt')->nullable();
            $table->integer('sp_gt_note')->nullable();
            $table->integer('sp_note_footer')->nullable();
            $table->string('color_sheme')->nullable();
            $table->string('wfrom_company')->nullable();
            $table->string('wto_client')->nullable();
            $table->string('wfrom_date')->nullable();
            $table->string('wto_date')->nullable();
            $table->string('witem_code')->nullable();
            $table->string('wdescription')->nullable();
            $table->string('wquantity')->nullable();
            $table->string('wprice')->nullable();
            $table->string('wamount')->nullable();
            $table->string('wtotal')->nullable();
            $table->string('woutstanding')->nullable();
            $table->string('wgrandtotal')->nullable();
            $table->string('wnote')->nullable();
            $table->string('wamout_total')->nullable();
            $table->string('wtotal_quantity')->nullable();
            $table->string('winvoice_number')->nullable();
            $table->string('rinvoice_number')->nullable();
            $table->string('rquantity')->nullable();
            $table->string('routstanding')->nullable();
            $table->string('rgrandtotal')->nullable();
            $table->integer('spcr')->nullable();

            $table->text('footer')->nullable();
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
        Schema::dropIfExists('v_models');
    }
}
