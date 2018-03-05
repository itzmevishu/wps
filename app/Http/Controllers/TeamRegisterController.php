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


class TeamRegisterController extends Controller {

    
   
    public function showForm(Request $request){


        return View::make('users.team-register');
    }

    public function createAccount(Request $request){
        $input=$request->all();

        $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'password' => array(
                          'required',
                          'confirmed',
                          'between:8,50',
                          'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                         ),
                'password_confirmation' => 'same:password',                
                'team_code' => 'required'
            ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            //return $messages;

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/team/register')->withInput()->withErrors($validator);

        }

        //litmos API
        $litmosAPI = new litmosAPI();

        //check if team exists
        $getTeam = $litmosAPI->getTeamID($input['team_code']);        
        $teamJsonCode = $getTeam->getStatusCode();
        $teamJson = json_decode($getTeam->getBody());

        if(count($teamJson) == 0){
            return Redirect::to('/team/register')->withInput()->with('errormsg','The team code '. $input['team_code'] .' was not found. Please check your team code and try again or contact your supervisor for assistance.');
        }


        

        //check if username is email
        if(filter_var($input['username'], FILTER_VALIDATE_EMAIL)){
            $email = $input['username'];
            $disableMessages = false;
            $isCustomUsername = false;

        }else{
            $email = '';
            $disableMessages = true;
            $isCustomUsername = true;

        }
        

        //check if username exists... if it does, add course to user's account
        $checkUserExistsRequest = $litmosAPI->apiUserExists($input['username']);

        //get status code for username exists
        $requestCode = $checkUserExistsRequest->getStatusCode();

        //success checking if user exists
        if($requestCode == 200 || $requestCode == 201) {

            return Redirect::to('/team/register')->withInput()->with('errormsg','This username has already been taken. Try a different username or email address.');

        }else{
            
            $postArray = [
            'Id'=>'',
            'UserName'=>$input['username'],
            'FirstName'=>$input['first_name'],
            'LastName'=>$input['last_name'],
            'FullName'=>'',
            'Email'=>$email,
            'AccessLevel'=>'learner',
            'DisableMessages'=>$disableMessages,
            'Active'=>true,
            'Skype'=>'',
            'PhoneWork'=>'',
            'PhoneMobile'=>'',
            'LastLogin'=>'',
            'LoginKey'=>'',
            'IsCustomUsername'=>$isCustomUsername,
            'Password'=>$input['password'],
            'SkipFirstLogin'=>true,
            'TimeZone'=>'',
            'Street1'=>'',
            'Street2'=>'',
            'City'=>'',
            'State'=>'',
            'PostalCode'=>'',
            'Country'=>'',
            'CompanyName'=>'',
            'JobTitle'=>'',
            'CustomField1'=>'',
            'CustomField2'=>'',
            'CustomField3'=>'',
            'CustomField4'=>'',
            'CustomField5'=>'',
            'CustomField6'=>'',
            'CustomField7'=>'',
            'CustomField8'=>'',
            'CustomField9'=>'',
            'CustomField10'=>'',
            'Culture'=>''
        ];


            //dd($postArray);

            //create user in Litmos
            $userCreateRequest = $litmosAPI->apiUserCreate($postArray,'false');

            //get request code
            $requestCode = $userCreateRequest->getStatusCode();

            //success creating user
            if($requestCode == 201 || $requestCode == 200){

                //get response
                $createJson = json_decode($userCreateRequest->getBody());

                //get api response's user id
                $lmsLoginKey = $createJson->LoginKey;

                $getTeam = $litmosAPI->getTeamID($input['team_code']);
                $teamJson = json_decode($getTeam->getBody());
                $teamJsonCode = $getTeam->getStatusCode();

                if($teamJsonCode == 201 || $teamJsonCode == 200){
                    $userTeamArray = $litmosAPI->createTeamArray($createJson->Id);
                    $assignTeam = $litmosAPI->apiAssignTeams($userTeamArray,$teamJson[0]->Id);
                    $teamStatusCode = $assignTeam->getStatusCode();
                }
                
                return Redirect::to($lmsLoginKey);

            }else{

                return Redirect::to('/team/register')->withInput()->with('errormsg','There was an issue creating your account. Please try again. If this issue persists, please contact Sentry at sentrypost@altec.com.');

            }
        }
    }

    

    

}
