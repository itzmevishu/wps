<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
                        $table->increments('id');
            $table->integer('order_id');
            $table->string('course_id',100);
            $table->string('course_code',100);
            $table->string('course_name',255);
            $table->string('module_id',100);
            $table->string('module_name',255);
            $table->string('session_id',100);
            $table->string('session_name',255);
            $table->string('location',100);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('qty');
            $table->double('course_price',15,2);
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
        Schema::drop('order_details');
    }
}
