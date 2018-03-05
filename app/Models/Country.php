<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model{

    public static function getCountryList(){
        $countries = Country::orderBy('order_by','ASC')->orderBy('country','ASC')->lists('country','country_code');

        return $countries;
    }

    public static function getCountry($country_name){
        $country = Country::where('country',$country_name)->first();

        return $country;
    }


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'country';

    //public static $table = 'plans';

}