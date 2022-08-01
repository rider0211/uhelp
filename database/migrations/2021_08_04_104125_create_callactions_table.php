<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callactions', function (Blueprint $table) {
            $table->id();
            $table->string('callcheck');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('buttonname');
            $table->string('buttonurl');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('callactions');
    }
}
