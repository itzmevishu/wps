<?php

use Illuminate\Database\Seeder;

class DropdownCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dropdown_categories')->delete();

        \DB::table('dropdown_categories')->insert(array (
            0 =>
                array (
                    'id' => '1',
                    'category_name' => 'Part A or Part B provider',
                    'created_at' => '0000-00-00 00:00:00',
                    'updated_at' => '0000-00-00 00:00:00',
                ),
            1 =>
                array (
                    'id' => '2',
                    'category_name' => 'Facility or Provider Type',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            2 =>
                array (
                    'id' => '3',
                    'category_name' => 'MAC Jurisdiction',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            3 =>
                array (
                    'id' => '4',
                    'category_name' => 'Physician Specialty Code',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
        ));

    }
}
