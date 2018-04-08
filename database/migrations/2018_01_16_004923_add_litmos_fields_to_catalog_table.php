<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLitmosFieldsToCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalog', function (Blueprint $table) {
            /*
              $table->char('lms_course_id', 50);
              $table->char('lms_sku', 20);
              $table->char('z_price', 10)->nullable();
              $table->char('lms_title', 255);
            */
            $table->char('course_id', 50);
            $table->char('code', 20);
            $table->char('name', 255);
            $table->boolean('for_sale')->nullable();
            $table->integer('original_id')->nullable();
            $table->text('description')->nullable();
            $table->string('ecommerce_short_description')->nullable();
            $table->string('ecommerce_long_description')->nullable();
            $table->char('course_code_for_bulk_import', 20)->nullable();
            $table->char('price', 10)->nullable();
            $table->char('access_till_date')->nullable();
            $table->boolean('course_team_Library')->nullable();
            //$table->dropColumn(['litmos_id', 'litmos_price', 'litmos_title', 'litmos_shortDesc', 'litmos_keywords']);

        });

        DB::statement('ALTER TABLE catalog ADD FULLTEXT full(name, description, 	ecommerce_short_description, ecommerce_long_description)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalog', function (Blueprint $table) {
            //
        });
    }
}
