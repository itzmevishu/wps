<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static function createProfile($provider_name, $phone_number, $timezone, $npi, $ptan, $specialty = '') {
        $profile = new Profile();
        $profile->provider_name = $provider_name;
        $profile->phone_number = $phone_number;
        $profile->timezone = $timezone;
        $profile->npi = $npi;
        $profile->ptan = $ptan;
        $profile->specialty = $specialty;
        $profile->save();
        return $profile;
    }

    public static function updateProfile($profile_id, $provider_name, $phone_number, $timezone, $npi, $ptan, $specialty) {
        $profile = Profile::find($profile_id);
        $profile->provider_name = $provider_name;
        $profile->phone_number = $phone_number;
        $profile->timezone = $timezone;
        $profile->npi = $npi;
        $profile->ptan = $ptan;
        $profile->specialty = $specialty;
        $profile->save();
        return $profile;
    }
}
