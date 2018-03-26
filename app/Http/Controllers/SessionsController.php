<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use View;
use Form;
use Cart;
use Auth;
use Session;
use Mail;

class SessionsController extends Controller
{

    public function impersonate($id)
    {
        $user = User::find($id);


       Auth::user()->setImpersonating($user->id);

        return redirect('/account/profile');
    }

    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        //flash()->success('Welcome back!');

        return redirect('/admin/users');
    }



    public function create(Request $request)
    {
        $request->session()->flash('url',$request->header('referer'));

        if ($request->input('courseid') != ''){
            if(Auth::check()) return Redirect::to('/confirm-course?courseid='.$request->input('courseid'));
        }else{
            if(Auth::check()) return Redirect::to('/welcome');
        }


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


        return View::make('users.login',['states'=>$states,'countries'=>$countries,'userMsg'=>$request->session()->get('userMsg'),'courseID'=>$courseID,'timeZones'=>$timeZoneList]);
    }

    public function store(Request $request)
    {       
        $input=$request->all();

        $rules=[
            'username'=>'required',
            'password'=>'required'
        ];


        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/login')->withInput()->withErrors($validator);

            //var_dump($input);

        }


        if(Auth::attempt(array('email' => $input['username'], 'password' => $input['password'], 'active' => 1)))

       {
           $userAuth= Auth::user();

           if ($input['course_id'] != ''){
               return Redirect::to('/confirm-course?courseid='.$input['course_id']);
           }else{
               return redirect()->intended('welcome');
           }

       }else{

            //check if user in DB

            $isUser = User::where('username',$input['username'])->first();
            //return $isUser;

            if(count($isUser) == 0){
                return Redirect::action('AccountController@findVerifyLMSAccount', array('username'=>$input['username']));
            }else{
                if($isUser->vc_flag == 1 || $isUser->vc_flag == 88){
                    return Redirect::to('/registration-issue');
                }

                if($isUser->active == 0 && $isUser->vc_flag == 0){
                    $user_token = uniqid('', true);

                    $user = User::updateUserToken($isUser['id'],$user_token);

                    $email_array = array('userToken'=>$user_token,'first_name'=>$isUser['first_name'],'last_name'=>$isUser['last_name'],'email'=>$isUser['email'],'url'=>env('APP_URL'));

                    //return $email_array['file'];
                    Mail::queue('emails.lmsVerification', $email_array, function ($message) use ($email_array) {
                        $message->to($email_array['email'], $email_array['first_name'].' '.$email_array['last_name'])->subject('Altec Store Verification');
                    });

                    return Redirect::to('/email-verification');
                }else{
                    return Redirect::back()->withInput()->with('message','Either your username or password is incorrect. <br>Try resetting your <a href="/password/reset">password</a>');
                }

            }

        }

        return Redirect::back()->withInput()->with('message','Either your username or password is incorrect. <br>Try resetting your <a href="/password/reset">password</a>');
    }

    public function destroy()
    {

        //return 'here';

        Cart::instance('shopping')->destroy();
        Cart::instance('promo')->destroy();
        Cart::instance('bogo')->destroy();

        Auth::logout();

        return Redirect::to('/');
    }

}