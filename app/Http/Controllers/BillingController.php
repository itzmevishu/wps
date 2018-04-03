<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Billing;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\CourseAssignment;
use App\Functions\helpers;
use App\Functions\litmosAPI;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;

use Auth;
use Form;
use Session;
use View;
use DB;


class BillingController extends Controller {

    public function showOrder($orderId){

        $getRecentOrder = Orders::where('id',$orderId)->where('success',true)->first();

        if($getRecentOrder['payment_id'] == 'free'){
            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promo_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();

            return View::make('billing/show-order-free',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);

        }else{
            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promos_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();

            return View::make('billing/show-order',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);
        }


        

    }


    public function getAllInvoices()
    {

        $userAuth= Auth::user();
        $getRecentOrder = Orders::where('user_id',$userAuth->id)->where('success',true)->orderby('created_at','desc')->paginate(10);


        return View::make('billing.show-orders',['allOrders'=>$getRecentOrder]);

    }

    public function showBilling()
    {
        $userAuth= Auth::user();


        $countries = Country::lists('country','country');
        $states = State::lists('name','name');
        $billing = Billing::where('user_id',$userAuth->id)->first();


        return View::make('billing.show-billing',['paymentInfo'=>$billing,'userAuth'=>$userAuth,'states'=>$states,'countries'=>$countries]);

    }

    public function updateAddress()
    {
        $userAuth= Auth::user();
        $input = Input::all();

        $rules=[
            'address1'=>'required|between:1,255',
            'address2'=>'between:1,255',
            'country'=>'required',
            'state'=>'required|between:1,40',
            'city'=>'required|between:1,40',
            'zipCode'=>'required|between:1,20',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/billing')->withInput()->withErrors($validator);

        }



        return Redirect::to('/billing')->with('message','Billing address updated!');
    }

    public function showAssignForm($seatid){
        //return 'to other form';

        //get assignment details
        $seatDetails=CourseAssignment::find($seatid);
        $courseDetails=OrderDetails::find($seatDetails->order_detail_id);
        $countries = Country::lists('country','country');
        $states = State::lists('name','name');

        $timeZoneList = [

            'Eastern Standard Time'=>'Eastern Timezone',
            'Central Standard Time'=>'Central Timezone',
            'Mountain Standard Time' => 'Mountain Timezone',
            'Pacific Standard Time' => 'Pacific Timezone',
            'Alaskan Standard Time'=>'Alaskan Timezone',
            'Hawaiian Standard Time' => 'Hawaiian Timezone'
        ];

        //return $courseDetails;

        $userAuth= Auth::user();

        //return assignment form

        return View::make('billing.assign-form',['course'=>$courseDetails,'states'=>$states,'countries'=>$countries,'timeZones'=>$timeZoneList,'seatid'=>$seatid]);
    }


    public function assignCourseToSelf($seatid){
        $userAuth= Auth::user();
        CourseAssignment::updateExistingUserAssignments('self',$userAuth['litmos_id'],$userAuth['first_name']
                                ,$userAuth['last_name'],$userAuth['username'],$userAuth['company_name'],$seatid);

        $seatDetails=CourseAssignment::find($seatid);
        $courseDetails=OrderDetails::find($seatDetails->order_detail_id);

        if($courseDetails->session_id != '') {
            //do not send emails from LMS
            $sendMessage = 'false';
            $newCourse = litmosAPI::createSingleCourseXML($courseDetails->course_id);

            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $userAuth['litmos_id']);
            $requestCode = $getCourseRequest->getStatusCode();

            if ($requestCode == 201) {
                $getCourseSessionRequest = litmosAPI::apiSessionRegistration($courseDetails->course_id, $courseDetails->module_id, $courseDetails->session_id, $userAuth['litmos_id']);
                $requestCode2 = $getCourseSessionRequest->getStatusCode();

                if($requestCode2 == 200){
                    $assignSuccess = true;
                    //send ILT email
                    helpers::emailILTSession($courseDetails->course_name,$courseDetails->session_name,$courseDetails->location,$courseDetails->start_date,$courseDetails->end_date,$userAuth['first_name'],$userAuth['last_name'],$userAuth['username']);

                    return Redirect::to('/orders/order-details/'.$courseDetails->order_id);

                }else{
                    $assignSuccess = false;
                }
            }else{
                $assignSuccess = false;
            }
        }else{
            $sendMessage = 'true';
            $newCourse = litmosAPI::createSingleCourseXML($courseDetails->course_id);

            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $userAuth['litmos_id']);
            $requestCode = $getCourseRequest->getStatusCode();

            if ($requestCode == 201) {

                return Redirect::to('/orders/order-details/'.$courseDetails->order_id);

            }else{
                $assignSuccess = false;
            }

        }
    }

    public function assignCourseToExisting($seatid,Request $request){

        $input = $request->all();

        CourseAssignment::updateExistingUserAssignments('existing',$input['litmosid'],$input['firstname']
                                ,$input['lastname'],$input['username'],$input['company_name'],$seatid);

        $seatDetails=CourseAssignment::find($seatid);
        $courseDetails=OrderDetails::find($seatDetails->order_detail_id);

        if($courseDetails->session_id != '') {
            //do not send emails from LMS
            $sendMessage = 'false';
            $newCourse = litmosAPI::createSingleCourseXML($courseDetails->course_id);

            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $input['litmosid']);
            $requestCode = $getCourseRequest->getStatusCode();

            if ($requestCode == 201) {
                $getCourseSessionRequest = litmosAPI::apiSessionRegistration($courseDetails->course_id, $courseDetails->module_id, $courseDetails->session_id, $input['litmosid']);
                $requestCode2 = $getCourseSessionRequest->getStatusCode();

                if($requestCode2 == 200){
                    $assignSuccess = true;
                    //send ILT email
                    helpers::emailILTSession($courseDetails->course_name,$courseDetails->session_name,$courseDetails->location,$courseDetails->start_date,$courseDetails->end_date,$input['firstname'],$input['lastname'],$input['username']);

                    return Redirect::to('/orders/order-details/'.$courseDetails->order_id);

                }else{
                    $assignSuccess = false;
                }
            }else{
                $assignSuccess = false;
            }
        }else{
            $sendMessage = 'true';
            $newCourse = litmosAPI::createSingleCourseXML($courseDetails->course_id);

            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $input['litmosid']);
            $requestCode = $getCourseRequest->getStatusCode();

            if ($requestCode == 201) {

                return Redirect::to('/orders/order-details/'.$courseDetails->order_id);

            }else{
                $assignSuccess = false;
            }

        }
    }

    public function assignCourseToNew($seatid,Request $request){

        $input=$request->all();


        $rules=[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'provider_company'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip_code'=>'required',
            'work_phone'=>'required|between:10,15',
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

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/billing/assign-to-form/'.$seatid.'?show=1&sec=new')->withInput()->withErrors($validator);

            //var_dump($validator);

        }

        //create user here
        $newUserArray = litmosAPI::createNewAssigned($input, false, 'learner', true, false, true);
        $userCreateRequest = litmosAPI::apiUserCreate($newUserArray, 'true');

        $requestCode = $userCreateRequest->getStatusCode();

        if ($requestCode == 201) {

            //get response
            $createJson = json_decode($userCreateRequest->getBody());

            CourseAssignment::updateExistingUserAssignments('existing',$createJson->Id,$input['first_name']
                                ,$input['last_name'],$input['email'],$input['provider_company'],$seatid);

            $seatDetails=CourseAssignment::find($seatid);
        $courseDetails=OrderDetails::find($seatDetails->order_detail_id);

        if($courseDetails->session_id != '') {
            //do not send emails from LMS
            $sendMessage = 'false';
            $newCourse = litmosAPI::createSingleCourseXML($courseDetails->course_id);

            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $createJson->Id);
            $requestCode = $getCourseRequest->getStatusCode();

            if ($requestCode == 201) {
                $getCourseSessionRequest = litmosAPI::apiSessionRegistration($courseDetails->course_id, $courseDetails->module_id, $courseDetails->session_id, $createJson->Id);
                $requestCode2 = $getCourseSessionRequest->getStatusCode();

                if($requestCode2 == 200){
                    $assignSuccess = true;
                    //send ILT email
                    helpers::emailILTSession($courseDetails->course_name,$courseDetails->session_name,$courseDetails->location,$courseDetails->start_date,$courseDetails->end_date,$input['first_name'],$input['last_name'],$input['email']);

                    return Redirect::to('/orders/order-details/'.$courseDetails->order_id);

                }else{
                    $assignSuccess = false;
                }
            }else{
                $assignSuccess = false;
            }
        }else{
            $sendMessage = 'true';
            $newCourse = litmosAPI::createSingleCourseXML($courseDetails->course_id);

            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $createJson->Id);
            $requestCode = $getCourseRequest->getStatusCode();

            if ($requestCode == 201) {

                return Redirect::to('/orders/order-details/'.$courseDetails->order_id);

            }else{
                $assignSuccess = false;
            }

        }

        }
    }

    
}


