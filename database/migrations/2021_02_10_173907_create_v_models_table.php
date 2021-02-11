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
        Schema::create('v_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('invoice_title');
            $table->boolean('c_name_v');
            $table->boolean('c_address_v');
            $table->boolean('c_tel_v');
            $table->boolean('c_country_v');
            $table->boolean('c_email_v');
            $table->boolean('cl_name_v');
            $table->boolean('cl_address_v');
            $table->boolean('cl_tel_v');
            $table->boolean('cl_country_v');
            $table->boolean('cl_email_v');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->boolean('from_date_v');
            $table->boolean('to_date_v');
            $table->integer('title_sp');
            $table->text('text1');
            $table->boolean('text1_v');
            $table->text('note1');
            $table->text('note2');
            $table->text('note3');
            $table->text('note4');
            $table->boolean('note1_v');
            $table->boolean('note2_v');
            $table->boolean('note3_v');
            $table->boolean('note4_v');
            $table->integer('pdf_mr');
            $table->integer('pdf_ml');
            $table->integer('pdf_mt');
            $table->integer('sp_gt_note');
            $table->integer('sp_note_footer');
            $table->string('color_sheme');
            $table->string('wfrom_company');
            $table->string('wto_client');
            $table->string('wfrom_date');
            $table->string('wto_date');
            $table->string('witem_code');
            $table->string('wdescription');
            $table->string('wquantity');
            $table->string('wprice');
            $table->string('wamount');
            $table->string('wtotal');
            $table->string('woutstanding');
            $table->string('wgrandtotal');
            $table->string('wnote');
            $table->string('wamout_total');
            $table->string('wtotal_quantity');
            $table->string('winvoice_number');
            $table->string('rinvoice_number');
            $table->string('rquantity');
            $table->string('routstanding');
            $table->string('rgrandtotal');
            $table->integer('spcr');

            $table->text('footer');
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
