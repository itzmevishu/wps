<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Catalog;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\SerialNumbers;
use App\Models\TokenUsers;
use App\Models\FreeFAM;
use App\Models\CourseAssignment;
use App\Models\Profile;
use App\Models\Address;
use App\Models\ProfileField;
use App\Models\ProfileFieldValue;
use App\Models\Dropdown;
use App\Models\DropdownCategory;
use App\Functions\litmosAPI;
use App\Functions\helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

//use Request;
use Auth;
use Crypt;
use Form;
use DB;
use Mail;
use Session;
use View;


class AccountController extends Controller {

    public function findUser(Request $request){

        $input = $request->all();
        $checkUserExistsRequest = litmosAPI::apiUserExists($input['userEmail']);
        $requestCode = $checkUserExistsRequest->getStatusCode();


        if($requestCode == 200){
            return $checkUserExistsRequest->getBody();
        } else {
            return $requestCode;
        }
    }

    public function loginForm(){

        $states = State::getStateList();


        return View::make('users.login',['states'=>$states]);
    }
   
    public function registrationForm(Request $request){

        $states = State::getStateList();
        $countries = Country::getCountryList();

        $courseID = $request->input("courseid");

        $timeZoneList = [

            'Eastern Standard Time'=>'Eastern Timezone',
            'Central Standard Time'=>'Central Timezone',
            'Mountain Standard Time' => 'Mountain Timezone',
            'Pacific Standard Time' => 'Pacific Timezone',
            'Alaskan Standard Time'=>'Alaskan Timezone',
            'Hawaiian Standard Time' => 'Hawaiian Timezone'
        ];



        return View::make('users.register',['states'=>$states,'countries'=>$countries,'courseID'=>$courseID,'timeZones'=>$timeZoneList]);
    }

    public function getLMSAccountInfo(Request $request)
    {
        $input=$request->all();

        $rules=[
           'username'=>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/verify-account-form')->withInput()->withErrors($validator);

            //var_dump($input);

        }
    }


    public function createAccount(Request $request){

        $input = $request->all();

        //check if we have the id in the local db
        $userInfo = User::where('email',$input['email_address'])->first();

        if(count($userInfo) && $userInfo->active == 0){
            $user_token = uniqid('', true);

            //user exists and send them to password reset
            User::updateUserToken($userInfo['id'],$user_token);

            $email_array = array('userToken'=>$user_token,'first_name'=>$userInfo['first_name'],'last_name'=>$userInfo['last_name'],'email'=>$userInfo['email'],'url'=>env('APP_URL'));

            //return $email_array['file'];
            Mail::send('emails.lmsVerification', $email_array, function ($message) use ($email_array) {
                $message->to($email_array['email'], $email_array['first_name'].' '.$email_array['last_name'])->subject('eComm Demo Verification');
            });

            return Redirect::to('/email-verification');

        }

        if(count($userInfo) && $userInfo->active == 0 && $userInfo->vc_flag == 1){
            return Redirect::to('/registration-issue');
        }


        $rules=[
            'first_name'=>'required',
            'last_name'=>'required',
            'email_address'=>'required|email',
            'email_address_confirm'=>'same:email_address',
            'password'=>'required|confirmed|between:8,50',
            'password_confirmation'=>'same:password',
            'provider_company'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip_code'=>'required|numeric',
            'work_phone'=>'required|numeric',
            'timezone'=>'required',
            'national_provider_identifier'=>'required|digits:10',
            'provider_transaction_access_number'=>'required',
            'part_a_or_part_b_provider'=>'required',
            'MAC_jurisdiction'=>'required',
            'primary_facility_or_provider_type'=>'required'
        ];
       

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            //return $messages;

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/new-account')->withInput()->withErrors($validator);

        }

        //create user
        $litmosAPI = new litmosAPI();

        $newUserArray = $litmosAPI->createUserArray($input,false,'learner',true,false,true,$input['password']);

        //check if username exists... if it does, add course to user's account
        $checkUserExistsRequest = $litmosAPI->apiUserExists($input['email_address']);

        //get status code for username exists
        $requestCode = $checkUserExistsRequest->getStatusCode();

        //success checking if user exists
        if($requestCode == 200) {

            $checkUserExistsRequest = json_decode($checkUserExistsRequest->getBody());

            $user_token = uniqid('', true);

            $request = $request->instance();
            $request->setTrustedProxies([env('TRUSTED_PROXY')]);
            $clientIP = $request->getClientIp();


            $user = User::createExistingLMSLogin($input,$checkUserExistsRequest->Id,$checkUserExistsRequest->OriginalId,$user_token,$clientIP);

            $email_array = array('userToken'=>$user_token,'first_name'=>$user['first_name'],'last_name'=>$user['last_name'],'email'=>$user['email'],'url'=>env('APP_URL'));

            //return $email_array['file'];
            Mail::send('emails.lmsVerification', $email_array, function ($message) use ($email_array) {
                $message->to($email_array['email'], $email_array['first_name'].' '.$email_array['last_name'])->subject('Altec eComm Demo Verification');
            });

            return Redirect::to('/email-verification');


        }else{
            //create user in Litmos
            $userCreateRequest = $litmosAPI->apiUserCreate($newUserArray,'true');

            //get request code
            $requestCode = $userCreateRequest->getStatusCode();

            //success creating user
            if($requestCode == 201){

                //get response
                $createJson = json_decode($userCreateRequest->getBody());

                //get api response's user id
                $lmsUserID = $createJson->Id;
                $lmsOriginalID = $createJson->OriginalId;

                $request = $request->instance();
                $request->setTrustedProxies([env('TRUSTED_PROXY')]);
                $clientIP = $request->getClientIp();

                try {
                    if (!User::getUserByEmail($input['email_address'])) {
                        $profileId = 0;
                        $profile = Profile::createProfile($input['provider_company'], $input['work_phone'], $input['timezone'], $input['national_provider_identifier'], $input['provider_transaction_access_number'], $input['custom_9']);
                        if ($profile->id > 0) {
                            $profileId = $profile->id;
                            Address::createAddress($profileId, $input['address'], $input['city'], $input['state'], $input['zip_code']);
                            $this->updateProfileFieldValues($profileId, $input);
                        }
                        #$user = User::createUser($input['first_name'], $input['last_name'], $input['email_address'], $input['password'], $profileId, $lmsUserID);
                        #Auth::loginUsingId($user->id);

                        $user = User::createNewLogin($input,$lmsUserID,$lmsOriginalID,$clientIP);
                        #Auth::login($user);
                        Auth::loginUsingId($user->id);
                    }
                } catch (Exception $e) {
                    Log::error($e);
                }



                // using your customer id we will create
                // brain tree customer id with same id
                /*$response = \Braintree_Customer::create([
                   'id' => $user->id
                ]);

                // save your braintree customer id
                if( $response->success) {
                    $user->braintree_id = $response->customer->id;
                    $user->save();
                }*/



            }else{

                return Redirect::to('/new-account')->with('errormsg','We were not able to create your account.');

            }
        }

        return redirect()->intended('store-catalog');

    }

    
    public function verifyMessage(){

        return View::make('users.email-verification');

    }

    public function singleSignOn(){

        $userAuth = Auth::user();

        //return $userAuth['litmos_id'];

        $loginURL = litmosAPI::apiSSO($userAuth['litmos_id']);

        $loginURL = json_decode($loginURL->getBody());

        //dd($loginURL->LoginKey);

        return Redirect::to($loginURL->LoginKey);
    }

    public function activationCodes()
    {
        $userAuth= Auth::user();

        $get_activation_code = DB::table('ecomm_user_tokens')->select('ecomm_user_tokens.serial_number','ecomm_user_tokens.id','ecomm_user_tokens.activation_code',
            'ecomm_catalog.lms_title','ecomm_user_tokens.updated_at')->where('user_id',$userAuth->id)
        ->join('ecomm_catalog','ecomm_catalog.id','=','ecomm_user_tokens.catalog_id')->paginate(15);

        return View::make('users.activation-codes',['activation_codes'=>$get_activation_code]);

    }

    public function newActivation(){
        return View::make('users.activation-form');
    }

    public function addActivation(Request $request){

        $input=$request->all();

        $userAuth= Auth::user();

        $rules = [                
                'serial_number' => 'required',
                'activation_code' => 'required'
            ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/account/new-vehicle')->withInput()->withErrors($validator);

        }

        if($input['serial_number'] != ''){
            //check serial number
            $serial_number = $input['serial_number'];
            $serial_number = str_replace (" ", "", $serial_number);
            $serial_number = str_replace ("-", "", $serial_number);
            $serial_number = strtoupper($serial_number);
            $serial_number_hash = SHA1($serial_number);
            $isSerialNumber = SerialNumbers::where('HASHED_VALUE',$serial_number_hash)->where('active',1)->first();

            //return $isSerialNumber;

            if(! $isSerialNumber){

                return Redirect::to('/account/new-vehicle')->withInput()->with('errormsg','This is not a valid serial number.');
            }
        }

        if($input['activation_code'] != ''){
            //check if activation code is valid
            $activation_code = Catalog::where('lms_sku','like','%'.$input['activation_code'])->first();

            if(! $activation_code){

                return Redirect::to('/account/new-vehicle')->withInput()->with('errormsg','This is not a valid activation code.');
            }
        }

        if($input['serial_number'] != '' && $input['activation_code'] != ''){

            //check if activation codes are left
            $count_token_serial_use = DB::table('ecomm_user_tokens')->where('activation_code',$input['activation_code'])->where('serial_id',$isSerialNumber->id)->count();

            //check if this user has used this combo before
            $user_token_combo = DB::table('ecomm_user_tokens')->where('activation_code',$input['activation_code'])->where('serial_number',$serial_number)->where('user_id',$userAuth->id)->count();
            

            if($count_token_serial_use < $isSerialNumber->token_count && $user_token_combo == 0){
                //assign this user to this course
                $sendMessage = 'true';

                $course_array = litmosAPI::createSingleCourseXML($activation_code->lms_course_id);
                $assign_course = litmosAPI::apiAssignCourseSession($course_array,$sendMessage,$userAuth->litmos_id);

                $addUser = new TokenUsers;
                $addUser->activation_code = strtoupper($input['activation_code']);
                $addUser->user_id = $userAuth->id;
                $addUser->serial_number= Crypt::encrypt($serial_number);
                $addUser->catalog_id=$activation_code->id;
                $addUser->serial_id=$isSerialNumber->id;
                $addUser->save();


                //if course being assigned is a GEN class, also give them opportunity to choose ONE FAM course
                if(stristr($activation_code->lms_sku, '-GEN-')){
                     //add user to FAM LU table w/ empty promoid code (this is how we stop people from getting to choose page on their own without valid activation codes)

                    $newFAM = new FreeFAM;
                    $newFAM->user_id = $userAuth->id;
                    $newFAM->active = 1;
                    $newFAM->user_token_id=$addUser->id;
                    $newFAM->save();

                    //send user an email here
                    helpers::emailFreeFAM($userAuth);

                    //send them to page to choose their free FAM Course
                    return Redirect::to('/account/register-vehicle');
                }
               

            }else{
                return Redirect::to('/account/register-vehicle')->with('errormsg','The activation code you entered is no longer valid. For questions, please contact Altec Sentry at 205.408.8260');
            }
        }

        return Redirect::to('/account/register-vehicle');
    }

    public function thankYou()
    {

        //return $cartInfo;

        return View::make('thank-you');
    }

    public function accountExists()
    {
        return View::make('users.user-exists');
    }

    public function editUser()
    {
        $userAuth= Auth::user();

        $states = State::getStateList();
        $countries = Country::getCountryList();

        $timeZoneList = [

            'Eastern Standard Time'=>'Eastern Timezone',
            'Central Standard Time'=>'Central Timezone',
            'Mountain Standard Time' => 'Mountain Timezone',
            'Pacific Standard Time' => 'Pacific Timezone',
            'Alaskan Standard Time'=>'Alaskan Timezone',
            'Hawaiian Standard Time' => 'Hawaiian Timezone'
        ];

        return View::make('users.edit-user',['states'=>$states,'timeZones'=>$timeZoneList,'countries'=>$countries,'user'=>$userAuth]);

    }

    public function VCFlagged()
    {
        return View::make('users.vc-flagged');

    }

    public function setCurrencyUSD()
    {
        $userAuth= Auth::user();

        $updateUser = User::setCurrency($userAuth['id'],'usd');

        Auth::login($updateUser);

        return 'usd';

    }

    public function setCurrencyEURO()
    {
        $userAuth= Auth::user();

        $updateUser = User::setCurrency($userAuth['id'],'euro');

        Auth::login($updateUser);

        return 'euro';

    }

    public function findLMSAccount(Request $request){

        $input=$request->all();
        //check if username exists... if it does, add course to user's account
        $checkUserExistsRequest = litmosAPI::apiUserExists($input['email']);

        //get status code for username exists
        $requestCode = $checkUserExistsRequest->getStatusCode();

        //success checking if user exists
        if($requestCode == 200) {
            $checkUserExistsRequest = json_decode($checkUserExistsRequest->getBody());

            //return $checkUserExistsRequest;


            return View::make('users.verify-user',['userinfo'=>$checkUserExistsRequest,'verify'=>0]);

        }

    }

    public function createLMSAccount(Request $request){

        $input=$request->all();

        $rules=[

            'password'=>'required|confirmed|between:8,50',
            'password_confirmation'=>'same:password'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/lms/find-user?username='.$input['email'])->withInput()->withErrors($validator);

            //var_dump($input);

        }

        if($input['verify']){
            $user_token = uniqid('', true);

            $request = $request->instance();
            $request->setTrustedProxies([env('TRUSTED_PROXY')]);
            $clientIP = $request->getClientIp();

            //user exists and send them to password reset
            $user = User::createExistingLMSLogin($input,$input['litmos_id'],$input['litmos_original_id'],$user_token,$clientIP);

            $email_array = array('userToken'=>$user_token,'first_name'=>$user['first_name'],'last_name'=>$user['last_name'],'email'=>$user['email'],'url'=>env('APP_URL'));

            //return $email_array['file'];
            Mail::send('emails.lmsVerification', $email_array, function ($message) use ($email_array) {
                $message->to($email_array['email'], $email_array['first_name'].' '.$email_array['last_name'])->subject('Altec eComm Demo Verification');
            });

            return Redirect::to('/email-verification');
        }else{

            $request = $request->instance();
            $request->setTrustedProxies([env('TRUSTED_PROXY')]);
            $clientIP = $request->getClientIp();

            $user = User::createNewLogin($input,$input['litmos_id'],$input['litmos_original_id'],$clientIP);

            Auth::login($user);

            return Redirect::to('/confirm-course?courseid='.$input['courseid']);
        }
    }

    public function findVerifyLMSAccount(Request $request)
    {
        $input=$request->all();
        //check if username exists... if it does, add course to user's account
        $checkUserExistsRequest = litmosAPI::apiUserExists($input['email']);

        //get status code for username exists
        $requestCode = $checkUserExistsRequest->getStatusCode();

        //success checking if user exists
        if($requestCode == 200) {

            $checkUserExistsRequest = json_decode($checkUserExistsRequest->getBody());

            //return $checkUserExistsRequest;


            return View::make('users.verify-user',['userinfo'=>$checkUserExistsRequest,'verify'=>1]);

        }else{
            return Redirect::to('/new-account')->with('email',$input['email']);
        }

    }

    public function verifyLMSAccount(Request $request){

        $input=$request->all();

        $getUser = User::where('lms_sync_token',$input['token'])->first();

        if($input['token']==$getUser['lms_sync_token']){

            $user = User::updateExistingLMSLogin($getUser);

            Auth::login($user);

            return redirect()->intended('welcome');

        }else{
            return View::make('users.verify-not-found');
        }

    }

    public function updateAccount(Request $request){

        $input=$request->all();

        $userAuth= Auth::user();


        //return $input;
        
            $rules=[
                'email'=>'required|email|unique:users,email,'.$input['id'].',id',                
                'first_name'=>'required',
                'last_name'=>'required',
                'password'=> array(
                          'confirmed',
                          'between:8,50',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),
                'password_confirmation'=>'same:password'              
            ];
        

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            //return $messages;

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/account/profile')->withInput()->withErrors($validator);

        }

        /*
         * need to double check the email address and see if it's in use... if it's different.
         */

        $currentEmail = $userAuth['email'];

        if($currentEmail <> $input['email'] ){
            //check if username exists...
            $checkUserExistsRequest = litmosAPI::apiUserExists($input['email']);

            //get status code for username exists
            $requestCode = $checkUserExistsRequest->getStatusCode();

            //success checking if user exists
            if($requestCode == 200) {
                //send user back w/ note about username is being used
                return Redirect::to('/account/profile')->with('errorMsg','The email address you have entered is associated to another account.');
            }
        }


        $updateUserArray = litmosAPI::updateUserArray($input,$userAuth['litmos_id'],false,'Learner',true,false,true,$input['password']);

        //return $updateUserArray;

        $updateUser = litmosAPI::apiUserUpdate($updateUserArray,$userAuth['litmos_id']);
        $updateUserRequestCode = $updateUser->getStatusCode();

        //return $updateUser->json();

        //success updating user
        if($updateUserRequestCode != 200) {
            return Redirect::to('/account/profile')->with('errorMsg','We had an issue updating your profile. Please try again. 1');
        }

        $user = User::updateExistingLogin($input,$userAuth['id']);

        Auth::login($user);

        return Redirect::to('/account/profile')->with('message','Profile updated!');


    }

    private function updateProfileFieldValues($profileId, $input) {

        $profileFields = ProfileField::getProfileFieldsKeyedByName();
        $dropdownCategories = DropdownCategory::getDropdownCategoriesKeyedByName();

        //Part A or Part B Provider
        if(isset($input['part_a_or_part_b_provider']) && !empty($input['part_a_or_part_b_provider'])) {
            $partAorBFieldId = $profileFields['Are you a Part A or Part B provider?'];
            $partAorBDropdown = Dropdown::getByCategoryIdAndOptionName($dropdownCategories['Part A or Part B provider'], $input['part_a_or_part_b_provider']);
            ProfileFieldValue::updateProfileFieldValue($profileId, $partAorBFieldId, $partAorBDropdown->id);
        }

        //MAC_Jurisdiction
        if(isset($input['MAC_jurisdiction']) && !empty($input['MAC_jurisdiction'])) {
            $macJurisdictionFieldId = $profileFields['Which MAC Jurisdiction are you a part of?'];
            $macJurisdictionDropdown = Dropdown::getByCategoryIdAndOptionName($dropdownCategories['MAC Jurisdiction'], $input['MAC_jurisdiction']);
            ProfileFieldValue::updateProfileFieldValue($profileId, $macJurisdictionFieldId, $macJurisdictionDropdown->id);
        }

        //Primary Provider Type
        if(isset($input['primary_facility_or_provider_type']) && !empty($input['primary_facility_or_provider_type'])) {
            $primaryProviderTypeFieldId = $profileFields['Primary Facility or Provider Type'];
            $primaryProviderTypeDropdown = Dropdown::getByCategoryIdAndOptionName($dropdownCategories['Facility or Provider Type'], $input['primary_facility_or_provider_type']);
            ProfileFieldValue::updateProfileFieldValue($profileId, $primaryProviderTypeFieldId, $primaryProviderTypeDropdown->id);
        }

        //Secondary Provider Type
        if(isset($input['custom_6']) && !empty($input['custom_6'])) {
            $secondaryProviderTypeFieldId = $profileFields['Secondary Facility or Provider Type'];
            $secondaryProviderTypeDropdown = Dropdown::getByCategoryIdAndOptionName($dropdownCategories['Facility or Provider Type'], $input['custom_6']);
            ProfileFieldValue::updateProfileFieldValue($profileId, $secondaryProviderTypeFieldId, $secondaryProviderTypeDropdown->id);
        }

        //Tertiary Provider Type
        if(isset($input['custom_7']) && !empty($input['custom_7'])) {
            $tertiaryroviderTypeFieldId = $profileFields['Tertiary Facility or Provider Type'];
            $tertiaryProviderTypeDropdown = Dropdown::getByCategoryIdAndOptionName($dropdownCategories['Facility or Provider Type'], $input['custom_7']);
            ProfileFieldValue::updateProfileFieldValue($profileId, $tertiaryroviderTypeFieldId, $tertiaryProviderTypeDropdown->id);
        }

        //Physician Specialty Code
        if(isset($input['custom_8']) && !empty($input['custom_8'])) {
            $physicianSpecialtyCodeFieldId = $profileFields['Physician Specialty Code'];
            $physicianSpecialtyCodeDropdown = Dropdown::getByCategoryIdAndOptionName($dropdownCategories['Physician Specialty Code'], $input['custom_8']);
            ProfileFieldValue::updateProfileFieldValue($profileId, $physicianSpecialtyCodeFieldId, $physicianSpecialtyCodeDropdown->id);
        }
    }

    /*
     * Complete User Profile
     */

    public function completeProfile($email){

        $checkUserExistsRequest = litmosAPI::apiUserExists($email);
        $requestCode = $checkUserExistsRequest->getStatusCode();


        if($requestCode == 200){

        } else {
            // Redirect user to Invalid page
        }

        $user = User::getUserByEmail($email);
        $getStates = wpsStates();
        $getProvidersAB = wpsProviderAB();
        $getMACJurisdiction = wpsMACJurisdiction();
        $getFacilityProvider = wpsFacilityProvider();
        $getSpecialtyCodes = wpsSpecialtyCodes();
        $getTimeZones = wpsTimeZones();
        $profile_values = array();
        $profile_fields = ProfileField::getProfileFieldsKeyedById();
        try {
            $profile = Profile::find($user->profile_id);
            if(isset($profile)) {
                $address = Address::getByProfileId($profile->id);
                $profile_field_values = ProfileFieldValue::getProfileFieldValues($profile->id);
                foreach ($profile_field_values as $profile_field_value) {
                    $dropdown = Dropdown::find($profile_field_value->dropdown_id);
                    $profile_values[$profile_fields[$profile_field_value->profile_field_id]] = $dropdown->option_name;
                }
            } else {
                $address = $profile_values = array();
            }
        }
        catch (Exception $e) {
            Log::error($e);
        }
        return View::make('users.edit-profile', ['timeZones' => $getTimeZones, 'states' => $getStates, 'providerAB' => $getProvidersAB, 'macJurisdiction' => $getMACJurisdiction, 'facilityProvider' => $getFacilityProvider, 'specialtyCodes' => $getSpecialtyCodes, 'user' => $user, 'profile' => $profile, 'address' => $address, 'profile_values' => $profile_values]);
    }


    public function updateProfile(Request $request){

        $input = $request->all();

        $rules=[
            'first_name'=>'required',
            'last_name'=>'required',
            'password'=> array(
                'confirmed',
                'between:8,50',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
            ),
            'password_confirmation'=>'same:password'
        ];


        $validator = Validator::make($input, $rules);
        $email = $input['email'];
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            //return $messages;

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('account/profile/'.$email)->withInput()->withErrors($validator);

        }

        /*
         * need to double check the email address and see if it's in use... if it's different.
         */
        $input['email_address'] = $email;
        $userAuth = User::getUserByEmail($email);


        $updateUserArray = litmosAPI::updateUserArray($input,$userAuth['litmos_id'],false,'Learner',true,false,true,$input['password']);

        //return $updateUserArray;

        $updateUser = litmosAPI::apiUserUpdate($updateUserArray,$userAuth['litmos_id']);
        $updateUserRequestCode = $updateUser->getStatusCode();

        //return $updateUser->json();

        //success updating user
        if($updateUserRequestCode != 200) {
            return Redirect::to('/account/profile/'.$email)->with('errorMsg','We had an issue updating your profile. Please try again. 1');
        }


        try {
            if (User::getUserByEmail($input['email_address'])) {
                $profileId = 0;
                $profile = Profile::createProfile($input['provider_company'], $input['work_phone'], $input['timezone'], $input['national_provider_identifier'], $input['provider_transaction_access_number'], $input['custom_9']);
                if ($profile->id > 0) {
                    $profileId = $profile->id;
                    Address::createAddress($profileId, $input['address'], $input['city'], $input['state'], $input['zip_code']);
                    $this->updateProfileFieldValues($profileId, $input);
                }
                $input['profile_id'] = $profileId;
                $user = User::updateExistingLogin($input,$userAuth['id']);
                Auth::loginUsingId($user->id);
            }
        } catch (Exception $e) {
            Log::error($e);
        }

        return Redirect::to('/')->with('message','Profile updated!');


    }


}
