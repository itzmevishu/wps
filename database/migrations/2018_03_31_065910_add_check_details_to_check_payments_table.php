<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckDetailsToCheckPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheque_payments', function (Blueprint $table) {
            $table->char('check_amount', 10);
            $table->char('check_number', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cheque_payments', function (Blueprint $table) {
            //
        });
    }
}
