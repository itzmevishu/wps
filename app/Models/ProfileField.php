<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileField extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profile_fields';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static function getProfileFields() {
        return ProfileField::all();
    }

    public static function getProfileFieldsKeyedByName() {
        $profile_fields_arr = array();
        $profile_fields = ProfileField::getProfileFields();
        foreach($profile_fields as $profile_field) {
            $profile_fields_arr[$profile_field->profile_field_name] = $profile_field->id;
        }
        return $profile_fields_arr;
    }

    public static function getProfileFieldsKeyedById() {
        $profile_fields_arr = array();
        $profile_fields = ProfileField::getProfileFields();
        foreach($profile_fields as $profile_field) {
            $profile_fields_arr[$profile_field->id] = $profile_field->profile_field_name;
        }
        return $profile_fields_arr;
    }

}
