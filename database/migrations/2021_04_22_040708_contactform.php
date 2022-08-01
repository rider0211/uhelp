<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contactform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactforms', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->string('name'); 
            $table->string('email'); 
            $table->string('phone_number')->nullable(); 
            $table->string('subject')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('message'); 
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
        Schema::drop("contactforms");
    }
}
