<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// table with movies
class Movies extends Model
{
//    make table
    public function up(){
        Schema::create('movie', function (Blueprint $table){
            $table->increments('id');
            $table->string('name', 35);
            $table->dateTimeTz('last_update');
            $table->boolean('tracking');
            $table->smallInteger('s');
            $table->smallInteger('e');
            $table->string('url', 75);
            $table->string('img', 255);
        });
    }

//    delete table
    public function down(){
        Schema::drop('movie');
    }
}