<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('promo_code',50);
            $table->string('promo_desc',200);
            $table->boolean('promo_single_use')->default(0);
            $table->boolean('promo_dollar_off')->default(0);
            $table->boolean('promo_percent_off')->default(0);
            $table->boolean('promo_stackable')->default(0);            
            $table->string('promo_apply_to',45);
            $table->integer('promo_type_id');
            $table->date('promo_start_dt');
            $table->date('promo_end_dt');
            $table->boolean('promo_no_expiry')->default(0);
            $table->boolean('promo_enable')->default(0);
            $table->boolean('promo_active')->default(0);
            $table->double('promo_amount',15,2);
            $table->boolean('promo_all_products_req')->default(0);
            $table->integer('promo_qty');
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
        Schema::drop('promos');
    }
}
