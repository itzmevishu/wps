<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->char('provider_name', 100);
            $table->char('npi', 100);
            $table->char('ptan', 100);
            $table->string('address');
            $table->char('city', 50);
            $table->char('state', 20);
            $table->char('country', 20);
            $table->char('zip_code', 10);
            $table->char('phone', 15);
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
        Schema::drop('cheque_payments');
    }
}
