<?php

use Illuminate\Database\Seeder;

class ProfileFieldsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('profile_fields')->delete();
        
		\DB::table('profile_fields')->insert(array (
			0 => 
			array (
				'id' => '1',
				'profile_field_name' => 'Are you a Part A or Part B provider?',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => '2',
				'profile_field_name' => 'Primary Facility or Provider Type',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => '3',
				'profile_field_name' => 'Tertiary Facility or Provider Type',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => '4',
				'profile_field_name' => 'Which MAC Jurisdiction are you a part of?',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			4 => 
			array (
				'id' => '5',
				'profile_field_name' => 'Secondary Facility or Provider Type',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			5 => 
			array (
				'id' => '6',
				'profile_field_name' => 'Physician Specialty Code',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
