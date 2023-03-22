<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('aa_gipedou');
            $table->string('eps_name', 40);
            $table->string('sort_name', 40);
            $table->string('smsName', 40);
            $table->string('fild', 100);
            $table->tinyinteger('apoditiria');
            $table->integer('Sheets');
            $table->string('address', 45);
            $table->string('tk', 5);
            $table->string('map', 500);
            $table->string('city', 50);
            $table->string('city2', 50);
            $table->string('city3', 50);
            $table->integer('Kms');
            $table->integer('Kms2');
            $table->integer('Kms3');
            $table->decimal('diodia',10,2);
            $table->decimal('diodia2',10,2);
            $table->decimal('diodia3',10,2);
            $table->double('latitude');
            $table->double('longitude');
            $table->double('zoom');
            $table->string('administrator', 50);
            $table->string('tel_admin', 15);
            $table->tinyinteger('active');
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
        Schema::dropIfExists('fields');
    }
}
