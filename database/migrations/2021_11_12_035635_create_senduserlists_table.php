<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenduserlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senduserlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mail_id');
            $table->foreign('mail_id')->references('id')->on('sendmails')->onCascade('UPDATE')->onCascade('DELETE');
            $table->unsignedBigInteger('touser_id')->nullable();
            $table->foreign('touser_id')->references('id')->on('users')->onCascade('UPDATE')->onCascade('DELETE');
            $table->unsignedBigInteger('tocust_id')->nullable();
            $table->foreign('tocust_id')->references('id')->on('customers')->onCascade('UPDATE')->onCascade('DELETE');
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
        Schema::dropIfExists('senduserlists');
    }
}
