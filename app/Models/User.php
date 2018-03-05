<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Hash;
use Session;

class User extends Authenticatable
{

    protected $table = 'users';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function getUserByEmail($email) {
        return User::where('email', '=', $email)->first();
    }

    public static function createUser($first_name, $last_name, $email, $password, $profile_id = 0, $litmos_id = '') {
        $user = new User;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = Hash::make($password);
        if($profile_id > 0) {
            $user->profile_id = $profile_id;
        }
        if(!empty($litmos_id)) {
            $user->litmos_id = $litmos_id;
        }
        $user->save();
        return $user;
    }

    public static function updateUser($user_id, $first_name, $last_name, $email) {
        $user = User::find($user_id);
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->save();
        return $user;
    }

    public static function createNewLogin($userInput,$lmsUserID,$lmsOriginalID,$clientIP){
        $user = new User;
        $user->name=$userInput['first_name'].' '.$userInput['last_name'];
        $user->first_name=$userInput['first_name'];
        $user->last_name=$userInput['last_name'];        
        $user->email = $userInput['email_address'];
        $user->username=$userInput['email_address'];
        $user->password=Hash::make($userInput['password']);
        $user->litmos_id =$lmsUserID;
        $user->litmos_original_id = $lmsOriginalID;      
        $user->active=1;
        $user->save();
        return $user;
    }

    public static function createExistingLMSLogin($userInput,$lmsUserID,$lmsOriginalID,$lmsToken,$clientIP){
        $user = new User;
        $user->name=$userInput['first_name'].' '.$userInput['last_name'];
        $user->first_name=$userInput['first_name'];
        $user->last_name=$userInput['last_name'];        
        $user->email = $userInput['email_address'];
        $user->username=$userInput['email_address'];
        $user->password=Hash::make($userInput['password']);
        $user->lms_flag=1;
        $user->litmos_id =$lmsUserID;
        $user->litmos_original_id = $lmsOriginalID;
        $user->lms_sync_token=$lmsToken;
        $user->save();
        return $user;
    }

    public static function updateExistingLogin($userInput,$userid){
        $user = User::find($userid);
        $user->name=$userInput['first_name'].' '.$userInput['last_name'];
        $user->first_name=$userInput['first_name'];
        $user->last_name=$userInput['last_name'];        
        $user->email = $userInput['email_address'];
        $user->username=$userInput['email_address'];
        $user->password=Hash::make($userInput['password']);
        if(isset($userInput['profile_id'])){
            $user->profile_id = $userInput['profile_id'];
        }
        $user->save();
        return $user;
    }

    public static function updateExistingLMSLogin($userInput){
        $user = User::find($userInput['id']);
        $user->lms_flag=0;
        $user->active=1;
        $user->save();
        return $user;
    }

    public static function updateUserToken($userId,$lmsToken){
        $user = User::find($userId);
        $user->lms_sync_token=$lmsToken;
        $user->save();
        return $user;
    }

    public function setImpersonating($id)
    {
        Session::put('impersonate', $id);
    }

    public function stopImpersonating()
    {
        Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return Session::has('impersonate');
    }
}
