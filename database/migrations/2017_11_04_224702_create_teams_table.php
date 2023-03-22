<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('team_id');
            $table->integer('parent');
            $table->integer('aa_epo');
            $table->string('afm',10)->nullable();
            $table->string('onoma_eps',45);
            $table->string('onoma_web',45);
            $table->string('onoma_SMS',45);
            $table->string('address',100)->nullable();
            $table->string('tel')->nullable();
            $table->string('emblem')->nullable();
            $table->integer('court');
            $table->integer('court2')->nullable();
            $table->string('fax')->nullable();
            $table->string('etos_idrisis')->nullable();
            $table->tinyinteger('active')->default(1);
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
        Schema::dropIfExists('teams');
    }
}
