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

    public static function createProfile($input) {
        $profile = new Profile();
        $profile->provider_name = $input['provider_company'];
        $profile->phone_number = $input['work_phone'];
        $profile->timezone = $input['timezone'];
        $profile->npi = $input['national_provider_identifier'];
        $profile->ptan = $input['provider_transaction_access_number'];
        $profile->specialty = $input['custom_9'];
        $profile->save();
        return $profile;
    }

    public static function updateProfile($profile_id,$input) {
        $profile = Profile::find($profile_id);
        $profile->provider_name = $input['provider_company'];
        $profile->phone_number = $input['work_phone'];
        $profile->timezone = $input['timezone'];
        $profile->npi = $input['national_provider_identifier'];
        $profile->ptan = $input['provider_transaction_access_number'];
        $profile->specialty = $input['custom_9'];
        $profile->save();
        return $profile;
    }
}
