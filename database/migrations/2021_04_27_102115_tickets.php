<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cust_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('ticket_id')->unique()->nullable();
            $table->string('subject');
            $table->string('priority')->nullable();
            $table->string('project')->nullable();
            $table->longtext('message');
            $table->string('status');
            $table->string('replystatus')->nullable();
            $table->bigInteger('toassignuser_id')->unsigned()->nullable();
            $table->bigInteger('myassignuser_id')->unsigned()->nullable();
            $table->datetime('last_reply')->nullable();
            $table->datetime('auto_replystatus')->nullable();
            $table->date('closing_ticket')->nullable();
            $table->date('auto_close_ticket')->nullable();
            $table->string('overduestatus')->nullable();
            $table->date('auto_overdue_ticket')->nullable();
            $table->foreign('cust_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
}
