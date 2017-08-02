<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Movie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie', function (Blueprint $table){
            $table->increments('id');
            $table->string('name', 35);
            $table->timestamps();
            $table->boolean('tracking');
            $table->smallInteger('season');
            $table->smallInteger('episode');
            $table->string('url', 75);
            $table->string('img', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movie');
    }
}
