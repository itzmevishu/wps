<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsToCheckPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheque_payments', function (Blueprint $table) {
            $table->string('seminar_name', 100)->after('order_id');
            $table->timestamp('seminar_date')->after('order_id');

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
