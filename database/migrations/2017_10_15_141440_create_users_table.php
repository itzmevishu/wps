<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name',255);
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('email',255);
            $table->string('username',255);
            $table->string('password',255);   // for JSON
            $table->boolean('site_admin')->default(0);
            $table->boolean('lms_flag')->default(0);
            $table->string('litmos_id',100);
            $table->integer('litmos_original_id');
            $table->string('lms_sync_token',100);
            $table->string('remember_token',100);
            $table->boolean('active')->default(0);            
            $table->datetime('last_login');
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
        Schema::drop('users');
    }
}
