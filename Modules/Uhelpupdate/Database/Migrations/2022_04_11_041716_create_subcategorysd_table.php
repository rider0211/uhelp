<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategorysd', function (Blueprint $table) {
            $table->id();
            $table->string('subcategoryname')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::create('subcategoryschild', function (Blueprint $table) {
            $table->bigInteger('subcategory_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->primary(['category_id', 'subcategory_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategorysd')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategorysd');
        Schema::dropIfExists('subcategoryschild');
    }
};
