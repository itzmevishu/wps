<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosUsedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos_used', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promo_id');
            $table->integer('user_id');
            $table->integer('order_id');            
            $table->double('promo_amt',15,2);
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
        Schema::drop('promos_used');
    }
}
