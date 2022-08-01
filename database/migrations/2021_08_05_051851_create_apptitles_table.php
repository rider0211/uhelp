<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApptitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apptitles', function (Blueprint $table) {
            $table->id();
            $table->string('searchtitle');
            $table->string('searchsub')->nullable();
            $table->string('featurecheck');
            $table->string('featuretitle');
            $table->string('featuresub')->nullable();
            $table->string('testimonialcheck');
            $table->string('testimonialtitle');
            $table->string('testimonialsub')->nullable();
            $table->string('faqcheck');
            $table->string('faqtitle');
            $table->string('faqsub')->nullable();
            $table->string('articlecheck');
            $table->string('articletitle');
            $table->string('articlesub')->nullable();
            $table->string('checkbox')->nullable();
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
        Schema::dropIfExists('apptitles');
    }
}
