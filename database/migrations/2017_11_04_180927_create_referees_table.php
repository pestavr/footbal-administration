<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referees', function (Blueprint $table) {
            $table->increments('refaa');
            $table->string('Lastname',100);
            $table->string('smsLastName',100);
            $table->string('Firstname',50);
            $table->string('Geniki',100);
            $table->string('Fname',40)->nullable();
            $table->date('Bdate')->nullable();
            $table->string('address',100)->nullable();
            $table->string('city',50)->nullable();
            $table->string('tk',5)->nullable();
            $table->string('tel',15)->nullable();
            $table->string('smstel',15)->nullable();
            $table->string('email',100)->nullable();
            $table->tinyinteger('active')->default(1);
            $table->tinyinteger('startpoint')->default(0);
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
        Schema::dropIfExists('referees');
    }
}
