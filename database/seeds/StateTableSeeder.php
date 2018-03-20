<?php
use App\Models\State;
use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->truncate();

        State::create(['name' => 'Alaska', 'abbreviation' => 'AK', 'country' => 'USA', 'country' => 'USA']);
        State::create(['name' => 'Alabama', 'abbreviation' => 'AL', 'country' => 'USA']);
        State::create(['name' => 'American Samoa', 'abbreviation' => 'AS', 'country' => 'USA']);
        State::create(['name' => 'Arizona', 'abbreviation' => 'AZ', 'country' => 'USA']);
        State::create(['name' => 'Arkansas', 'abbreviation' => 'AR', 'country' => 'USA']);
        State::create(['name' => 'California', 'abbreviation' => 'CA', 'country' => 'USA']);
        State::create(['name' => 'Colorado', 'abbreviation' => 'CO', 'country' => 'USA']);
        State::create(['name' => 'Connecticut', 'abbreviation' => 'CT', 'country' => 'USA']);
        State::create(['name' => 'Delaware', 'abbreviation' => 'DE', 'country' => 'USA']);
        State::create(['name' => 'District of Columbia', 'abbreviation' => 'DC', 'country' => 'USA']);
        State::create(['name' => 'Federated States of Micronesia', 'abbreviation' => 'FM', 'country' => 'USA']);
        State::create(['name' => 'Florida', 'abbreviation' => 'FL', 'country' => 'USA']);
        State::create(['name' => 'Georgia', 'abbreviation' => 'GA', 'country' => 'USA']);
        State::create(['name' => 'Guam', 'abbreviation' => 'GU', 'country' => 'USA']);
        State::create(['name' => 'Hawaii', 'abbreviation' => 'HI', 'country' => 'USA']);
        State::create(['name' => 'Idaho', 'abbreviation' => 'ID', 'country' => 'USA']);
        State::create(['name' => 'Illinois', 'abbreviation' => 'IL', 'country' => 'USA']);
        State::create(['name' => 'Indiana', 'abbreviation' => 'IN', 'country' => 'USA']);
        State::create(['name' => 'Iowa', 'abbreviation' => 'IA', 'country' => 'USA']);
        State::create(['name' => 'Kansas', 'abbreviation' => 'KS', 'country' => 'USA']);
        State::create(['name' => 'Kentucky', 'abbreviation' => 'KY', 'country' => 'USA']);
        State::create(['name' => 'Louisiana', 'abbreviation' => 'LA', 'country' => 'USA']);
        State::create(['name' => 'Maine', 'abbreviation' => 'ME', 'country' => 'USA']);
        State::create(['name' => 'Marshall Islands', 'abbreviation' => 'MH', 'country' => 'USA']);
        State::create(['name' => 'Maryland', 'abbreviation' => 'MD', 'country' => 'USA']);
        State::create(['name' => 'Massachusetts', 'abbreviation' => 'MA', 'country' => 'USA']);
        State::create(['name' => 'Michigan', 'abbreviation' => 'MI', 'country' => 'USA']);
        State::create(['name' => 'Minnesota', 'abbreviation' => 'MN', 'country' => 'USA']);
        State::create(['name' => 'Mississippi', 'abbreviation' => 'MS', 'country' => 'USA']);
        State::create(['name' => 'Missouri', 'abbreviation' => 'MO', 'country' => 'USA']);
        State::create(['name' => 'Montana', 'abbreviation' => 'MT', 'country' => 'USA']);
        State::create(['name' => 'Nebraska', 'abbreviation' => 'NE', 'country' => 'USA']);
        State::create(['name' => 'Nevada', 'abbreviation' => 'NV', 'country' => 'USA']);
        State::create(['name' => 'New Hampshire', 'abbreviation' => 'NH', 'country' => 'USA']);
        State::create(['name' => 'New Jersey', 'abbreviation' => 'NJ', 'country' => 'USA']);
        State::create(['name' => 'New Mexico', 'abbreviation' => 'NM', 'country' => 'USA']);
        State::create(['name' => 'New York', 'abbreviation' => 'NY', 'country' => 'USA']);
        State::create(['name' => 'North Carolina', 'abbreviation' => 'NC', 'country' => 'USA']);
        State::create(['name' => 'North Dakota', 'abbreviation' => 'ND', 'country' => 'USA']);
        State::create(['name' => 'Northern Mariana Islands', 'abbreviation' => 'MP', 'country' => 'USA']);
        State::create(['name' => 'Ohio', 'abbreviation' => 'OH', 'country' => 'USA']);
        State::create(['name' => 'Oklahoma', 'abbreviation' => 'OK', 'country' => 'USA']);
        State::create(['name' => 'Oregon', 'abbreviation' => 'OR', 'country' => 'USA']);
        State::create(['name' => 'Palau', 'abbreviation' => 'PW', 'country' => 'USA']);
        State::create(['name' => 'Pennsylvania', 'abbreviation' => 'PA', 'country' => 'USA']);
        State::create(['name' => 'Puerto Rico', 'abbreviation' => 'PR', 'country' => 'USA']);
        State::create(['name' => 'Rhode Island', 'abbreviation' => 'RI', 'country' => 'USA']);
        State::create(['name' => 'South Carolina', 'abbreviation' => 'SC', 'country' => 'USA']);
        State::create(['name' => 'South Dakota', 'abbreviation' => 'SD', 'country' => 'USA']);
        State::create(['name' => 'Tennessee', 'abbreviation' => 'TN', 'country' => 'USA']);
        State::create(['name' => 'Texas', 'abbreviation' => 'TX', 'country' => 'USA']);
        State::create(['name' => 'Utah', 'abbreviation' => 'UT', 'country' => 'USA']);
        State::create(['name' => 'Vermont', 'abbreviation' => 'VT', 'country' => 'USA']);
        State::create(['name' => 'Virgin Islands', 'abbreviation' => 'VI', 'country' => 'USA']);
        State::create(['name' => 'Virginia', 'abbreviation' => 'VA', 'country' => 'USA']);
        State::create(['name' => 'Washington', 'abbreviation' => 'WA', 'country' => 'USA']);
        State::create(['name' => 'West Virginia', 'abbreviation' => 'WV', 'country' => 'USA']);
        State::create(['name' => 'Wisconsin', 'abbreviation' => 'WI', 'country' => 'USA']);
        State::create(['name' => 'Wyoming', 'abbreviation' => 'WY', 'country' => 'USA']);
        State::create(['name' => 'Armed Forces Africa', 'abbreviation' => 'AE', 'country' => 'USA']);
        State::create(['name' => 'Armed Forces Americas (except Canada)', 'abbreviation' => 'AA', 'country' => 'USA']);
        State::create(['name' => 'Armed Forces Canada', 'abbreviation' => 'AE', 'country' => 'USA']);
        State::create(['name' => 'Armed Forces Europe', 'abbreviation' => 'AE', 'country' => 'USA']);
        State::create(['name' => 'Armed Forces Middle East', 'abbreviation' => 'AE', 'country' => 'USA']);
        State::create(['name' => 'Armed Forces Pacific', 'abbreviation' => 'AP', 'country' => 'USA']);
    }
}
