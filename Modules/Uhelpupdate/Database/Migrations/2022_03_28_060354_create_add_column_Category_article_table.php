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
        Schema::table('categories', function (Blueprint $table) {

            $table->longtext('categoryslug')->nullable()->after('display');
            $table->string('priority')->nullable()->after('categoryslug');
             
        });
        Schema::table('articles', function (Blueprint $table) {

            $table->longtext('articleslug')->nullable()->after('views');
            $table->longtext('subcategory')->nullable()->after('articleslug');
             
        });
        Schema::table('pages', function (Blueprint $table) {

            $table->string('viewonpages')->nullable()->after('pageslug');
            $table->boolean('status')->after('viewonpages');
             
        });
        Schema::table('tickets', function (Blueprint $table) {

            $table->bigInteger('subcategory')->nullable()->after('category_id');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_column_Category_article');
    }
};
