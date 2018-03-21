<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 2/5/2018
 * Time: 11:06 AM
 */

use App\Models\DropdownCategory;
use App\Models\Dropdown;
if (! function_exists('wpsStates')) {
    function wpsStates()
    {

        $statesList = [
            '' => 'Please Select Your State',
            'Alabama' => 'Alabama',
            'Alaska' => 'Alaska',
            'Arizona' => 'Arizona',
            'Arkansas' => 'Arkansas',
            'California' => 'California',
            'Colorado' => 'Colorado',
            'Connecticut' => 'Connecticut',
            'Delaware' => 'Delaware',
            'Florida' => 'Florida',
            'Georgia' => 'Georgia',
            'Hawaii' => 'Hawaii',
            'Idaho' => 'Idaho',
            'Illinois' => 'Illinois',
            'Indiana' => 'Indiana',
            'Iowa' => 'Iowa',
            'Kansas' => 'Kansas',
            'Kentucky' => 'Kentucky',
            'Louisiana' => 'Louisiana',
            'Maine' => 'Maine',
            'Maryland' => 'Maryland',
            'Massachusetts' => 'Massachusetts',
            'Michigan' => 'Michigan',
            'Minnesota' => 'Minnesota',
            'Mississippi' => 'Mississippi',
            'Missouri' => 'Missouri',
            'Montana' => 'Montana',
            'Nebraska' => 'Nebraska',
            'Nevada' => 'Nevada',
            'New Hampshire' => 'New Hampshire',
            'New Jersey' => 'New Jersey',
            'New Mexico' => 'New Mexico',
            'New York' => 'New York',
            'North Carolina' => 'North Carolina',
            'North Dakota' => 'North Dakota',
            'Ohio' => 'Ohio',
            'Oklahoma' => 'Oklahoma',
            'Oregon' => 'Oregon',
            'Pennsylvania' => 'Pennsylvania',
            'Rhode Island' => 'Rhode Island',
            'South Carolina' => 'South Carolina',
            'South Dakota' => 'South Dakota',
            'Tennessee' => 'Tennessee',
            'Texas' => 'Texas',
            'Utah' => 'Utah',
            'Vermont' => 'Vermont',
            'Virginia' => 'Virginia',
            'Washington' => 'Washington',
            'Washington D.C.' => 'Washington D.C.',
            'West Virginia' => 'West Virginia',
            'Wisconsin' => 'Wisconsin',
            'Wyoming' => 'Wyoming'
        ];
        return $statesList;
    }
}
 function wpsProviderAB(){
    $dropdown_category = DropdownCategory::where('category_name', '=', 'Part A or Part B provider')->first();
    return Dropdown::generateDropdown($dropdown_category->id);
}

 function wpsMACJurisdiction()
{
    $dropdown_category = DropdownCategory::where('category_name', '=', 'MAC Jurisdiction')->first();
    return Dropdown::generateDropdown($dropdown_category->id);
}

function wpsFacilityProvider()
{
    $dropdown_category = DropdownCategory::where('category_name', '=', 'Facility or Provider Type')->first();
    return Dropdown::generateDropdown($dropdown_category->id);
}

 function wpsSpecialtyCodes()
{
    $dropdown_category = DropdownCategory::where('category_name', '=', 'Physician Specialty Code')->first();
    return Dropdown::generateDropdown($dropdown_category->id);
}


 function wpsTimeZones()
{

    $timeZoneList = [

        'Eastern Standard Time'=>'Eastern Timezone',
        'Central Standard Time'=>'Central Timezone',
        'Mountain Standard Time' => 'Mountain Timezone',
        'Pacific Standard Time' => 'Pacific Timezone',
        'Alaskan Standard Time'=>'Alaskan Timezone',
        'Hawaiian Standard Time' => 'Hawaiian Timezone'
    ];
    return $timeZoneList;
}


function getFaqs(){
    $faqs = \Maven::get();
    return $faqs;
}

