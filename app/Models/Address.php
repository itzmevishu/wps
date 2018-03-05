<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static function createAddress($profile_id, $address_string, $city, $state, $zip_code) {
        $address = new Address();
        $address->profile_id = $profile_id;
        $address->address = $address_string;
        $address->city = $city;
        $address->state = $state;
        $address->zip_code = $zip_code;
        $address->save();
        return $address;
    }

    public static function getByProfileId($profile_id) {
        return Address::where('profile_id', '=', $profile_id)->first();
    }

    public static function updateAddress($profile_id, $address_string, $city, $state, $zip_code) {
        $address = self::getByProfileId($profile_id);
        $address->address = $address_string;
        $address->city = $city;
        $address->state = $state;
        $address->zip_code = $zip_code;
        $address->save();
        return $address;
    }
}
