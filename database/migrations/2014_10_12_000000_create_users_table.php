<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('empid')->nullable();
            $table->longText('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('email')->unique();
            $table->bigInteger('phone')->nullable();
            $table->longText('skills')->nullable();
            $table->longText('languagues')->nullable();
            $table->string('status');
            $table->string('image')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('timezone')->nullable();
            $table->bigInteger('darkmode')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->longText('username')->nullable();
            $table->string('gender')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('email')->unique();
            $table->string('userType');
            $table->string('status');
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('timezone')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('customers');
    }
}
