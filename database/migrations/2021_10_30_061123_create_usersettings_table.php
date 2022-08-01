<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersettings', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('users_id')->unsigned();
            $table->BigInteger('ticket_refresh')->nullable();
            $table->BigInteger('star5')->default(0);
            $table->BigInteger('star4')->default(0);
            $table->BigInteger('star3')->default(0);
            $table->BigInteger('star2')->default(0);
            $table->BigInteger('star1')->default(0);
            $table->foreign('users_id')->references('id')->on('users')->onCascade('UPDATE')->onCascade('DELETE');
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
        Schema::dropIfExists('usersettings');
    }
}
