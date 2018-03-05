<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Country;
use App\Models\State;
use App\Models\Currency;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\PromoUser;
use App\Models\CourseAssignment;
use App\Functions\helpers;
use App\Functions\litmosAPI;
use App\Functions\cardconnect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use View;
use Form;
use Log;
use Auth;
use Cart;
use Session;
use DB;

class CheckoutController extends Controller {

    public function stepOne( Request $request){

        $userAuth= Auth::user();

        $cart = Cart::instance('shopping')->content();
        $cartTotal = Cart::instance('shopping')->total();
        $cartCount = Cart::instance('shopping')->count();

        $discount = Cart::instance('promo')->total();

        $cartTotal =number_format($cartTotal, 2, '.', '');
        $discount =number_format($discount, 2, '.', '');

        if (Auth::check())
        {
            return View::make('checkout.assignSeats',['discount'=>$discount,'userInfo'=>$userAuth,'cart'=>$cart,'cartTotal'=>$cartTotal,'cartCount'=>$cartCount]);

        } else {

            return Redirect::to('/login')->with('userMsg','To complete your checkout, please either login or register.');
        }
    }

    public function checkoutPreview( Request $request){

        //Saved user data
        $userAuth= Auth::user();

        $states = State::getStateList();
        $countries = Country::getCountryList();


        //User inputs
        $userResponse =$request->all();

        if($userResponse['country'] == 'United States' || $userResponse['country'] == 'Canada'){

            $rules=[
                'zip_code'=>'required',
                'country'=>'required',
                'state'=>'required',
                'city'=>'required',
                'address_line_1'=>'required',
                'first_name'=>'required',
                'last_name'=>'required',
                'card_number'=>'required|digits_between:12,19',
                'card_type' => 'required',
                'exp_month'=>'required',
                'exp_year'=>'required',
                'card_code'=>'required|digits_between:3,4'
            ];

        }else{
            $rules=[
                'country'=>'required',
                'city'=>'required',
                'address_line_1'=>'required',
                'first_name'=>'required',
                'last_name'=>'required',
                'card_number'=>'required|digits_between:12,19',
                'card_type' => 'required',
                'exp_month'=>'required',
                'exp_year'=>'required',
                'card_code'=>'required|digits_between:3,4'
            ];
        }

        $validator = Validator::make($userResponse, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/checkout-step-2')->withInput()->withErrors($validator);

            //dd($messages);

        }

        //return $userResponse;

        //get user's zuora account number
        //$zAccount =  $userAuth['z_account_number'];

        //get the currency exchange rate
        $getCurrency = Currency::where('currency_type',$userAuth['curr_type'])->first();
        $currency_rate = $getCurrency['rate'];

        //get all cart info
        $cart = Cart::instance('shopping')->content();
        $cartTotal = Cart::instance('shopping')->total();
        $cartCount = Cart::instance('shopping')->count();

        $discount = Cart::instance('promo')->total();

        //dd(Cart::instance('promo')->content());

        $taxAmount = 0;

        //format cart total
        $cartTotal =number_format($cartTotal, 2, '.', '');
        $discount =number_format($discount, 2, '.', '');


        return View::make('checkout.preview',['userResponse'=>$userResponse,'discount'=>$discount,'cart'=>$cart,'currencyRate'=>$currency_rate,'cartTotal'=>$cartTotal,'cartCount'=>$cartCount,'cartTax'=>$taxAmount,'paymentInfo'=>$userResponse]);


    }


    public function checkoutComplete(Request $request){

        $userbilling =$request->all();
        $userAuth= Auth::user();

        //save order to order table
        $getOrderId=Orders::saveOrder($userAuth);
        $cartTotal = Cart::instance('shopping')->total();
        $discountTotal = Cart::instance('promo')->total();
        $orderTotal = $cartTotal - $discountTotal;

        if(isset($userbilling['free_checkout'])){
            //return $userbilling['free_checkout'];

            Orders::orderPaymentSuccess($getOrderId,'free',$orderTotal);

        }else{
            //return $userbilling;
            $cardConnect = CardConnect::authCapture($userbilling,$getOrderId);
            $cardConnectResponse = json_decode($cardConnect->getBody());

            $card_code = $cardConnectResponse->respstat;

            
            Log::info($cardConnectResponse);
            //return $cardConnectResponse;

            switch ($card_code) {
                case "A":
                    Orders::orderPaymentSuccess($getOrderId,$cardConnectResponse->retref,$orderTotal);
                    break;
                case "B":
                    return Redirect::to('/checkout-step-2')->with('errormsg','We had an issue charging your credit card. Please try again.')->with('billing_info',$userbilling);
                    break;
                case "C":
                    return Redirect::to('/checkout-step-2')->with('errormsg','We had an issue charging your credit card. Please contact your bank for more information.')->with('billing_info',$userbilling);
                    break;
                default:
                   return Redirect::to('/checkout-step-2')->with('errormsg','We had an issue charging your credit card. Please try again.')->with('billing_info',$userbilling);
            }

        }

        //get sessions from cart
        $searchSession =Cart::instance('shopping')->search(array('options' => array('type' => 'single session')));

        if($searchSession) {
            foreach ($searchSession as $sessionIds) {

                //get cart details for this session
                $sessionInfo = Cart::instance('shopping')->get($sessionIds);

                //get assign to array
                $assignToArray = $sessionInfo['options']['assignTo'];
                //get modules & session array
                $modSessionArray = $sessionInfo['options']['sessionmod'];


                //loop through all the modules and sessions to be assigned
                foreach ($modSessionArray as $sessionMod) {

                        $orderDetailId=OrderDetails::saveOrderDetails($getOrderId,$sessionInfo['id'],$sessionInfo['options']['course_sku'],$sessionInfo['name'],
                        $sessionMod['moduleid'],$sessionMod['module_name'],$sessionMod['sessionid'],
                        $sessionMod['session_name'],$sessionMod['location'],$sessionMod['start_date'],$sessionMod['end_date'],$sessionInfo['qty'],$sessionInfo['price']);


                    //dd($orderDetailId);
                    //loop through all the users that need to be created and/or assigned to the modules & sessions
                    foreach ($assignToArray as $assignTo) {

                        //do not send emails from LMS
                        $sendMessage = 'false';
                        $newCourse = litmosAPI::createSingleCourseXML($sessionInfo['id']);

                        //if assigning to existing LMS user
                        if ($assignTo['assign'] == 'existing' || $assignTo['assign'] == 'self') {
                            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $assignTo['litmosid']);
                            $requestCode = $getCourseRequest->getStatusCode();

                            if ($requestCode == 201) {
                                $getCourseSessionRequest = litmosAPI::apiSessionRegistration($sessionInfo['id'], $sessionMod['moduleid'], $sessionMod['sessionid'], $assignTo['litmosid']);
                                $requestCode2 = $getCourseSessionRequest->getStatusCode();

                                if($requestCode2 == 200){
                                    $assignSuccess = true;
                                    //send ILT email
                                    helpers::emailILTSession($sessionInfo['name'],$sessionMod['session_name'],$sessionMod['location'],$sessionMod['start_date'],$sessionMod['end_date'],$assignTo['firstname'],$assignTo['lastname'],$assignTo['litmosusername']);

                                }else{
                                    $assignSuccess = false;
                                }
                            }else{
                                $assignSuccess = false;
                            }

                            CourseAssignment::saveExistingUserAssignments($assignTo['assign'],$assignTo['litmosid'],$assignTo['firstname']
                                ,$assignTo['lastname'],$assignTo['litmosusername'],$orderDetailId,$assignSuccess,$assignTo['company']);
                        }

                        //creating new LMS user
                        if ($assignTo['assign'] == 'new') {
                            //check if user has been created

                            $checkUserExistsRequest = litmosAPI::apiUserExists($assignTo['litmosusername']);
                            $requestCode = $checkUserExistsRequest->getStatusCode();

                            if ($requestCode == 200) {
                                $existingUser = json_decode($checkUserExistsRequest->getBody());
                                $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $existingUser->Id);

                                $requestCode = $getCourseRequest->getStatusCode();

                                if ($requestCode == 201) {
                                    $getCourseSessionRequest = litmosAPI::apiSessionRegistration($sessionInfo['id'], $sessionMod['moduleid'], $sessionMod['sessionid'], $existingUser->Id);
                                    $requestCode2 = $getCourseSessionRequest->getStatusCode();

                                    if($requestCode2 == 200){
                                        $assignSuccess = true;

                                        helpers::emailILTSession($sessionInfo['name'],$sessionMod['session_name'],$sessionMod['location'],$sessionMod['start_date'],$sessionMod['end_date'],$assignTo['firstname'],$assignTo['lastname'],$assignTo['litmosusername']);
                                    }else{
                                        $assignSuccess = false;
                                    }

                                }else{
                                    $assignSuccess = false;
                                }

                                CourseAssignment::saveExistingUserAssignments('existing',$existingUser->Id,$existingUser->FirstName
                                    ,$existingUser->LastName,$existingUser->UserName,$orderDetailId,$assignSuccess,$existingUser->CompanyName);

                            } else {
                                $newUserArray = litmosAPI::createNewAssigned($assignTo, false, 'learner', true, false, true);
                                $userCreateRequest = litmosAPI::apiUserCreate($newUserArray, 'true');

                                $requestCode = $userCreateRequest->getStatusCode();

                                if ($requestCode == 201) {

                                    //get response
                                    $createJson = json_decode($userCreateRequest->getBody());

                                    //get api response's user id
                                    $lmsUserID = $createJson->Id;

                                    $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $lmsUserID);

                                    $requestCode = $getCourseRequest->getStatusCode();

                                    if ($requestCode == 201) {
                                        $getCourseSessionRequest = litmosAPI::apiSessionRegistration($sessionInfo['id'], $sessionMod['moduleid'], $sessionMod['sessionid'], $lmsUserID);
                                        $requestCode2 = $getCourseSessionRequest->getStatusCode();



                                        if($requestCode2 == 200){
                                            $assignSuccess = true;
                                        }else{
                                            $assignSuccess = false;
                                        }
                                    }
                                }else{
                                    $assignSuccess = false;
                                    $lmsUserID = '';
                                }

                                CourseAssignment::saveNewUserAssignments($assignTo,$lmsUserID,$orderDetailId,$assignSuccess);
                            }

                        }
                    }
                }
            }
        }
        //get sessions from cart
        $searchSession =Cart::instance('shopping')->search(array('options' => array('type' => 'single course')));

        if($searchSession) {
            foreach ($searchSession as $sessionIds) {

                //get cart details for this session
                $sessionInfo = Cart::instance('shopping')->get($sessionIds);

                //get assign to array
                $assignToArray = $sessionInfo['options']['assignTo'];

                $orderDetailId=OrderDetails::saveOrderDetails($getOrderId,$sessionInfo['id'],$sessionInfo['options']['course_sku'],
                    $sessionInfo['name'],'','','','','eLearing','','',$sessionInfo['qty'],$sessionInfo['price']);


                //loop through all the users that need to be created and/or assigned to the modules & sessions
                foreach ($assignToArray as $assignTo) {

                    if($assignTo['litmosid'] != ''){

                        //do not send emails from LMS
                        $sendMessage = 'true';
                        $newCourse = litmosAPI::createSingleCourseXML($sessionInfo['id']);

                        //if assigning to existing LMS user
                        if ($assignTo['assign'] == 'existing' || $assignTo['assign'] == 'self') {
                            $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $assignTo['litmosid']);
                            $requestCode = $getCourseRequest->getStatusCode();

                            if ($requestCode == 201) {

                                $assignSuccess = true;

                            }else{
                                $assignSuccess = false;
                            }

                            CourseAssignment::saveExistingUserAssignments($assignTo['assign'],$assignTo['litmosid'],$assignTo['firstname']
                                ,$assignTo['lastname'],$assignTo['litmosusername'],$orderDetailId,$assignSuccess,$assignTo['company']);
                        }

                        //creating new LMS user
                        if ($assignTo['assign'] == 'new') {
                            //check if user has been created

                            $checkUserExistsRequest = litmosAPI::apiUserExists($assignTo['litmosusername']);
                            $requestCode = $checkUserExistsRequest->getStatusCode();

                            if ($requestCode == 200) {
                                $existingUser = json_decode($checkUserExistsRequest->getBody());
                                $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $existingUser->Id);

                                $requestCode = $getCourseRequest->getStatusCode();

                                if ($requestCode == 201) {

                                    $assignSuccess = true;

                                }else{
                                    $assignSuccess = false;
                                }

                                CourseAssignment::saveExistingUserAssignments('existing',$existingUser->Id,$existingUser->FirstName
                                    ,$existingUser->LastName,$existingUser->UserName,$orderDetailId,$assignSuccess,$existingUser->CompanyName);

                            } else {
                                $newUserArray = litmosAPI::createNewAssigned($assignTo, false, 'learner', true, false, true);
                                $userCreateRequest = litmosAPI::apiUserCreate($newUserArray, true);

                                $requestCode = $userCreateRequest->getStatusCode();

                                if ($requestCode == 201) {

                                    //get response
                                    $createJson = json_decode($userCreateRequest->getBody());

                                    //get api response's user id
                                    $lmsUserID = $createJson->Id;

                                    $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $lmsUserID);

                                    $requestCode = $getCourseRequest->getStatusCode();

                                    if ($requestCode == 201) {
                                        $assignSuccess = true;
                                    }
                                }else{
                                    $assignSuccess = false;
                                    $lmsUserID = '';
                                }

                                CourseAssignment::saveNewUserAssignments($assignTo,$lmsUserID,$orderDetailId,$assignSuccess);
                            }

                        }

                    }else{
                        CourseAssignment::saveExistingUserAssignments('empty','',''
                            ,'','',$orderDetailId,'false','');
                    }
                }
            }
        }

        $promoDetails = Cart::instance('promo')->content();
        foreach($promoDetails as $promoDetail) {
            $promoUser = new PromoUser;
            $promoUser->promo_id=$promoDetail['id'];
            $promoUser->user_id=$userAuth['id'];
            $promoUser->order_id=$getOrderId;
            $promoUser->promo_amt=$promoDetail['subtotal'];
            $promoUser->save();
        }

        Orders::orderSuccess($getOrderId);
        Cart::instance('promo')->destroy();
        Cart::instance('shopping')->destroy();

        //send orderID to email helper to send confirmation email
        if(isset($userbilling['free_checkout'])){
            helpers::emailFreeOrderConfirmation($getOrderId);
        }else{
            helpers::emailOrderConfirmation($getOrderId);
        }
        
       
       return Redirect::to('/thank-you');

    }

    public function stepTwo(Request $request){

        $userbilling =$request->all();

        $userAuth = Auth::user();

        $states = State::getStateList();
        $countries = Country::getCountryList();

        //$eCommApp = App::make('eCommApp');

        if($userAuth['curr_type'] == 'USD'){
            //$paymentPageId = $eCommApp->zUSDPageID;
            //$paymentGatewayName = $eCommApp->zUSDGatewayName;
        }else{
            //$paymentPageId = $eCommApp->zEURPageID;
            //$paymentGatewayName = $eCommApp->zEURGatewayName;
        }

        $cart = Cart::instance('shopping')->content();
        $cartTotal = Cart::instance('shopping')->total();
        $cartCount = Cart::instance('shopping')->count();

        $discount = Cart::instance('promo')->total();

        $cartTotal =number_format($cartTotal, 2, '.', '');
        $discount =number_format($discount, 2, '.', '');

//dd($userbilling);
        if (Auth::check())
        {
            
            if($cartTotal == $discount){
                 $getCurrency = Currency::where('currency_type',$userAuth['curr_type'])->first();
                $currency_rate = $getCurrency['rate'];
        return View::make('checkout.preview-free',['discount'=>$discount,'cart'=>$cart,'currencyRate'=>$currency_rate,'cartTotal'=>$cartTotal,'cartCount'=>$cartCount]);

            }else{
                return View::make('checkout.checkout',['userBilling'=>$userbilling,'states'=>$states,'countries'=>$countries,'discount'=>$discount,'userInfo'=>$userAuth,'cart'=>$cart,'cartTotal'=>$cartTotal,'cartCount'=>$cartCount]);
            }

        } else {

           return Redirect::to('/login')->with('userMsg','To complete your checkout, please either login or register.');
        }

    }

    public function thankYou()
    {

        $userAuth= Auth::user();

        $getRecentOrder = Orders::where('user_id',$userAuth->id)->where('success',1)->orderby('created_at','desc')->first();

        if($getRecentOrder['payment_id'] == 'free'){
            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('ecomm_promos')->join('ecomm_promo_used','ecomm_promos.id','=','ecomm_promo_used.promo_id')->where('ecomm_promo_used.order_id',$getRecentOrder->id)->get();

            return View::make('thank-you-free',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);

        }else{
            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('ecomm_promos')->join('ecomm_promo_used','ecomm_promos.id','=','ecomm_promo_used.promo_id')->where('ecomm_promo_used.order_id',$getRecentOrder->id)->get();

            return View::make('thank-you',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);
        }
    }

    public function thankYouDemo()
    {
        return View::make('thank-you-demo'); 
    }


	

}
