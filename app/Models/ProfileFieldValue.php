<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileFieldValue extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profile_field_values';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static function getProfileFieldValues($profile_id) {
        return ProfileFieldValue::where('profile_id', '=', $profile_id)->get();
    }

    public static function updateProfileFieldValue($profile_id, $profile_field_id, $dropdown_id) {
        $profileFieldValue = ProfileFieldValue::where(array('profile_id' => $profile_id, 'profile_field_id' => $profile_field_id))->first();
        if(!isset($profileFieldValue->id)) {
            $profileFieldValue = new ProfileFieldValue();
            $profileFieldValue->profile_id = $profile_id;
            $profileFieldValue->profile_field_id = $profile_field_id;
        }
        $profileFieldValue->dropdown_id = $dropdown_id;
        $profileFieldValue->save();
        return $profileFieldValue;
    }

}
