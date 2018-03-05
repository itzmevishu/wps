<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_litmos_id');
            $table->integer('order_id');
            $table->boolean('order_status');
            $table->string('order_payment_id');
            $table->float('order_total');
            $table->dateTime('order_date');
            $table->string('course_id');
            $table->string('course_name');
            $table->string('module_id');
            $table->string('module_name');
            $table->string('session_id');
            $table->string('session_name');
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
        Schema::drop('order_logs');
    }
}
