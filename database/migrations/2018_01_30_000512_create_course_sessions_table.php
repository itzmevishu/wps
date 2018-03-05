<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('module_id')->nullable()->unsigned();
            $table->char('session_id');
            $table->char('name');
            $table->char('instructor_name');
            $table->char('location');
            $table->char('course_name');
            $table->char('module_name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('description');
            $table->integer('slots')->unsigned();
            $table->foreign('module_id')->references('id')->on('course_modules');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE course_sessions ADD FULLTEXT full(name, instructor_name, location, course_name, module_name, description )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
