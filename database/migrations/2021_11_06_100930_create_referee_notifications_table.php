<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefereeNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referee_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('match_id')->unsigned()->nullable();
            $table->bigInteger('referee_id')->unsigned()->nullable();
            $table->tinyInteger('notified')->nullable();
            $table->tinyInteger('accepted')->nullable();
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
        Schema::dropIfExists('referee_notifications');
    }
}
