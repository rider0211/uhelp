<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIPLISTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_p_l_i_s_t_s', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->string('country')->nullable();
            $table->string('entrytype')->nullable();
            $table->string('types')->nullable();
            $table->datetime('start')->nullable();
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
        Schema::dropIfExists('i_p_l_i_s_t_s');
    }
}
