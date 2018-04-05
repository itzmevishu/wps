<?php
namespace App\Http\Controllers;

use App\Models\ChequePayment;
use App\Http\Requests;
use App\Models\Country;
use App\Models\OrderLog;
use App\Models\Profile;
use App\Models\State;
use App\Models\Currency;
#use App\Models\User;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\PromoUser;
use App\Models\CourseAssignment;
use App\Functions\helpers;
use App\Functions\litmosAPI;
use App\Functions\cardconnect;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use View;
use Form;
use Log;
use Auth;
use Cart;
use Session;
use DB;
use PDF;

/** All Paypal Details class **/

use PayPal\Rest\ApiContext;

use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;

use PayPal\Api\Details;

use PayPal\Api\Item;

use PayPal\Api\ItemList;

use PayPal\Api\Payer;

use PayPal\Api\Payment;

use PayPal\Api\RedirectUrls;

use PayPal\Api\ExecutePayment;

use PayPal\Api\PaymentExecution;

use PayPal\Api\Transaction;


class CheckoutController extends Controller {

    private $user;
    private $cart;
    private $cartTotal;
    private $cartCount;
    private $discount;
    private $_api_context;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();

        /*
         * Cart variables
         */
        $this->cart = Cart::instance('shopping')->content();
        $this->cartTotal = Cart::instance('shopping')->total();
        $this->cartCount = Cart::instance('shopping')->count();
        $promo_discount = Cart::instance('promo')->total();
        $bogo_count = Cart::instance('bogo')->total();
        $this->discount = $promo_discount + $bogo_count;

        /** setup PayPal api context **/

        $paypal_conf = \Config::get('paypal');

        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));

        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    private function formatAmount($number){
        return number_format($number, 2, '.', '');
    }

    public function stepOne( Request $request){

        $this->cartTotal = $this->formatAmount($this->cartTotal);
        $this->discount = $this->formatAmount($this->discount);

        if (Auth::check())
        {
            return View::make('checkout.assignSeats',array('discount' => $this->discount,
                'userInfo' => $this->user,
                'cart' => $this->cart,
                'cartTotal' => $this->cartTotal,
                'cartCount' => $this->cartCount));

        } else {

            return Redirect::to('/login')->with('userMsg','To complete your checkout, please either login or register.');
        }
    }

    public function stepTwo(Request $request){

        $user_billing = $request->all();
        $states = State::getStateList();
        $countries = Country::getCountryList();
        $clientToken = \Braintree_ClientToken::generate();
        $this->cartTotal = $this->formatAmount($this->cartTotal);
        $this->discount = $this->formatAmount($this->discount);

        $page_data = array('discount'=>$this->discount,
            'cart' => $this->cart,
            'cartTotal' => $this->cartTotal,
            'cartCount' => $this->cartCount,
            'clientToken' => $clientToken);

        if (Auth::check())
        {
            if($this->cartTotal == $this->discount){
                //$getCurrency = App\Models\Currency::where('currency_type',$this->user['curr_type'])->first();
                //$currency_rate = $getCurrency['rate'];
                $currency_rate = 1;
                $page_data = array_merge($page_data, array('currencyRate' => $currency_rate));
                return View::make('checkout.preview-free',$page_data);
            }else{
                $page_data = array_merge($page_data, array('userBilling'=>$user_billing, 'states' => $states,
                    'countries' => $countries, 'userInfo' => $this->user));
                return View::make('checkout.checkout',$page_data);
            }
        } else {
            return Redirect::to('/login')->with('userMsg','To complete your checkout, please either login or register.');
        }

    }

    public function checkoutPreview( Request $request){
        $states = State::getStateList();
        $countries = Country::getCountryList();
        $userResponse = $request->all();
        $taxAmount = 0;
        $this->cartTotal = $this->formatAmount($this->cartTotal);
        $this->discount = $this->formatAmount($this->discount);

        return View::make('checkout.preview',['userResponse'=>$userResponse,
            'discount'=>$this->discount,
            'cart'=>$this->cart,
            'currencyRate'=>'',
            'cartTotal'=>$this->cartTotal,
            'cartCount'=>$this->cartCount,
            'cartTax'=>$taxAmount,
            'paymentInfo'=>$userResponse,
            'userAuth'=>$this->user,
            'states' => $states,
            'countries' => $countries
        ]);

    }

    public function checkoutComplete(Request $request){
        $cartTotal = $this->cartTotal;
        $discountTotal = $this->discount;

        $userbilling = $request->all();
        //save order to order table
        $order_id = Orders::saveOrder($this->user);

        $orderTotal = $cartTotal - $discountTotal;
        $payment_type = 'braintree'; // sprite
        $payment_status = false;

        if(isset($userbilling['free_checkout'])){
            Orders::orderPaymentSuccess($order_id,'free',$orderTotal);
        }elseif($payment_type == 'sprite'){
            $payment_status =  $this->__stripePayment($order_id, $userbilling);
        }else{
            $payment_status = $this->__braintreePayment($order_id, $request);
        }

        if($payment_status === false) {
            dd("Transaction failed");
        }

        $this->__singleSession($order_id);
        $this->__singleCourse($order_id);

        $promoDetails = Cart::instance('promo')->content();
        foreach($promoDetails as $promoDetail) {
            $promoUser = new PromoUser;
            $promoUser->promo_id = $promoDetail['id'];
            $promoUser->user_id = $this->user['id'];
            $promoUser->order_id = $order_id;
            $promoUser->promo_amt = $promoDetail['subtotal'];
            $promoUser->save();
        }

        Orders::orderSuccess($order_id);
        Cart::instance('promo')->destroy();
        Cart::instance('shopping')->destroy();

        //send orderID to email helper to send confirmation email
        if(isset($userbilling['free_checkout'])){
            #helpers::emailFreeOrderConfirmation($order_id);
        }else{
            #helpers::emailOrderConfirmation($order_id);
        }
        return Redirect::to('/thank-you');
    }

    public function thankYou()
    {

        $getRecentOrder = Orders::where('user_id',$this->user->id)->where('success',1)->orderby('created_at','desc')->first();

        if($getRecentOrder['payment_id'] == 'free'){
            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promos_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();

            return View::make('thank-you-free',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);

        }elseif($getRecentOrder['payment_id'] == 'check'){

            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promos_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();

            return View::make('thank-you-pdf',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);

        }else{
            $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

            $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

            $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promos_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();

            return View::make('thank-you',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'promoDetails'=>$getPromos]);
        }
    }

    public function thankYouDemo()
    {
        return View::make('thank-you-demo'); 
    }

    private function __stripePayment($getOrderId, $user_billing){

        $cartTotal = $this->cartTotal * 100;
        $userEmail = $user_billing['stripeEmail'];
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $stripeTokenResponse = \Stripe\Token::retrieve($user_billing['stripeToken']);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $stripePayment = \Stripe\Charge::create(array(
            "amount" => $cartTotal,
            "currency" => "usd",
            "receipt_email" => $userEmail,
            "source" =>  $user_billing['stripeToken'],
            "description" => "Charge for Litmos training."
        ));

        if($stripePayment->status == "succeeded"){
            Orders::orderPaymentSuccess($getOrderId,$stripePayment->id,$cartTotal/100);
            return true;
        }else{
            #dd($stripePayment);
            return false;
        }
    }

    private function __singleSession($order_id){
        //get sessions from cart
        $searchSession = Cart::instance('shopping')->search(array('options' => array('type' => 'single session')));
        Log::info($searchSession);
        if($searchSession) {

            foreach ($searchSession as $sessionIds) {

                //get cart details for this session
                $sessionInfo = Cart::instance('shopping')->get($sessionIds);

                //get assign to array
                $assignToArray = $sessionInfo['options']['assignTo'];
                //get modules & session array
                $modSessionArray = $sessionInfo['options']['sessionmod'];

                Log::info("modSessionArray");
                Log::info($modSessionArray);

                //loop through all the modules and sessions to be assigned
                foreach ($modSessionArray as $sessionMod) {

                    $orderDetailId = OrderDetails::saveOrderDetails($order_id,
                        $sessionInfo['id'],
                        $sessionInfo['options']['course_sku'],$sessionInfo['name'],
                        $sessionMod['moduleid'],$sessionMod['module_name'],$sessionMod['sessionid'],
                        $sessionMod['session_name'],$sessionMod['location'],$sessionMod['start_date'],
                        $sessionMod['end_date'],$sessionInfo['qty'],$sessionInfo['price']);

                    Log::info("Order details ID". $orderDetailId);

                    //dd($orderDetailId);
                    //loop through all the users that need to be created and/or assigned to the modules & sessions
                    foreach ($assignToArray as $assignTo) {
                        if($assignTo['litmosid'] != '') {
                            //do not send emails from LMS
                            $sendMessage = 'false';
                            $newCourse = litmosAPI::createSingleCourseXML($sessionInfo['id']);
                            Log::info("New Course");
                            Log::info($newCourse);
                            //if assigning to existing LMS user
                            if ($assignTo['assign'] == 'existing' || $assignTo['assign'] == 'self') {
                                $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $assignTo['litmosid']);


                                $requestCode = $getCourseRequest->getStatusCode();


                                if ($requestCode == 201) {
                                    $getCourseSessionRequest = litmosAPI::apiSessionRegistration($sessionInfo['id'], $sessionMod['moduleid'], $sessionMod['sessionid'], $assignTo['litmosid']);
                                    $requestCode2 = $getCourseSessionRequest->getStatusCode();

                                    if ($requestCode2 == 200) {
                                        Log::info("Assign Success");
                                        $assignSuccess = true;
                                        //send ILT email
                                        helpers::emailILTSession($sessionInfo['name'], $sessionMod['session_name'], $sessionMod['location'], $sessionMod['start_date'], $sessionMod['end_date'], $assignTo['firstname'], $assignTo['lastname'], $assignTo['litmosusername']);
                                    } else {
                                        $assignSuccess = false;
                                        $assignSuccess = false;
                                        Log::info("litmosAPI::apiSessionRegistration Failed");
//                                    Log::info($requestCode2->getBody());
                                    }
                                } else {
                                    $assignSuccess = false;
                                    Log::info("litmosAPI::apiAssignCourseSession Failed");
                                    //   Log::info($getCourseRequest->getBody());
                                }

                                CourseAssignment::saveExistingUserAssignments($assignTo['assign'], $assignTo['litmosid'],
                                    $assignTo['firstname']
                                    , $assignTo['lastname'], $assignTo['litmosusername'], $orderDetailId,
                                    $assignSuccess, $assignTo['company']);
                            }
                            Log::info("creating new LMS user :: " . $assignTo['assign']);
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

                                        if ($requestCode2 == 200) {
                                            $assignSuccess = true;

                                            helpers::emailILTSession($sessionInfo['name'], $sessionMod['session_name'], $sessionMod['location'], $sessionMod['start_date'], $sessionMod['end_date'], $assignTo['firstname'], $assignTo['lastname'], $assignTo['litmosusername']);
                                        } else {
                                            $assignSuccess = false;
                                        }

                                    } else {
                                        $assignSuccess = false;
                                    }

                                    CourseAssignment::saveExistingUserAssignments('existing', $existingUser->Id, $existingUser->FirstName
                                        , $existingUser->LastName, $existingUser->UserName, $orderDetailId, $assignSuccess, $existingUser->CompanyName);

                                } else {
                                    Log::info("creating new LMS leaner user :: " . $assignTo['assign']);
                                    $newUserArray = litmosAPI::createNewAssigned($assignTo, false, 'learner', true, false, true);
                                    $userCreateRequest = litmosAPI::apiUserCreate($newUserArray, 'true');

                                    $requestCode = $userCreateRequest->getStatusCode();
                                    Log::info("litmosAPI::createNewAssigned :: " . $requestCode);
                                    if ($requestCode == 201) {

                                        //get response
                                        $createJson = json_decode($userCreateRequest->getBody());

                                        //get api response's user id
                                        $lmsUserID = $createJson->Id;

                                        $getCourseRequest = litmosAPI::apiAssignCourseSession($newCourse, $sendMessage, $lmsUserID);

                                        $requestCode = $getCourseRequest->getStatusCode();
                                        Log::info("litmosAPI::apiAssignCourseSession:: " . $requestCode);
                                        if ($requestCode == 201) {
                                            $getCourseSessionRequest = litmosAPI::apiSessionRegistration($sessionInfo['id'], $sessionMod['moduleid'], $sessionMod['sessionid'], $lmsUserID);
                                            $requestCode2 = $getCourseSessionRequest->getStatusCode();
                                            Log::info("litmosAPI::apiSessionRegistration :: " . $requestCode2);
                                            if ($requestCode2 == 200) {
                                                $assignSuccess = true;
                                            } else {
                                                $assignSuccess = false;
                                            }
                                        }
                                    } else {
                                        $assignSuccess = false;
                                        $lmsUserID = '';
                                    }

                                    CourseAssignment::saveNewUserAssignments($assignTo, $lmsUserID, $orderDetailId, $assignSuccess);
                                }

                            }
                        }else{
                            CourseAssignment::saveExistingUserAssignments('empty','',''
                                ,'','',$orderDetailId,'false','');
                        }
                    }
                }
            }
        }

    }

    private function __singleCourse($order_id){

        //get sessions from cart
        #Cart::instance('shopping')->content();
        $searchSession = Cart::instance('shopping')->search(array('options' => array('type' => 'single course')));
        if($searchSession) {

            foreach ($searchSession as $sessionIds) {

                //get cart details for this session
                $sessionInfo = Cart::instance('shopping')->get($sessionIds);

                //get assign to array
                $assignToArray = $sessionInfo['options']['assignTo'];

                $orderDetailId=OrderDetails::saveOrderDetails($order_id,$sessionInfo['id'],$sessionInfo['options']['course_sku'],
                    $sessionInfo['name'],'','','','','eLearing',
                    '','',$sessionInfo['qty'],$sessionInfo['price']);


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
    }

    private function __braintreePayment($order_id, $request){
        $amount = 0 ;
        $transaction_id = 0;
        $transaction_status = false;
        if( $request->get('payment_method_nonce') )
        {
            // brain tree customer payment nouce
            $payment_method_nonce = $request->get('payment_method_nonce');
            $paymentAmount = $request->get('paymentAmount');


            // process the customer payment
            $result = \Braintree_Transaction::sale([
                'amount' => $paymentAmount,
                'channel'=> 'WPS Learning Center',
                'paymentMethodNonce' => $payment_method_nonce
            ]);

            // check to see if braintree has processed
            // our client purchase transaction
            if( !empty($result->transaction) ) {

                $transaction_status = true;
                $transaction_id = $result->transaction->id;
                $amount = $result->transaction->amount;

                $result = \Braintree_Transaction::submitForSettlement($transaction_id);

                if ($result->success) {
                    $settledTransaction = $result->transaction;
                    Orders::orderPaymentSuccess($order_id, $transaction_id, $amount);
                    Orders::orderSuccess($order_id);
                } else {
                    $transaction_status = false;
                }


            } else {
                # Redirect to failure page
                $transaction_status = false;
            }
        } else {
            $transaction_status = false;
        }
        return $transaction_status;
    }

    public function paymentOptions(Request $request){
        $userAuth = Auth::user();
        if(isset($userAuth->profile_id) && empty($userAuth->profile_id)){
            Session::flash('message', 'Please update profile information.');
            return redirect()->intended('/account/profile');
        }

        return View::make('checkout.payment_options');
    }

    public function selectPaymentOption(Request $request){
        $params = $request->all();
        if($params['payment_type'] == 'check'){
            session(['payment_type' => 'check']);
        } else {
            session(['payment_type' => 'paypal']);
        }
        return Redirect::to('/checkout-step-1');
    }

    public function payByCheque(Request $request){
        $states = State::getStateList();
        $countries = Country::getCountryList();
        $profile_id = Auth::user()->profile_id;
        $profile = Profile::find($profile_id);

        $attendees = array();
        if($this->cartCount){
            foreach ($this->cart as $key => $cartInfo){
                $cartIntemInfo = Cart::instance('shopping')->get($key);
                $getAssignTo = $cartIntemInfo->options->assignTo;
                $attendees =  array_merge($attendees, $getAssignTo);
            }
        }

        return View::make('checkout.pay_by_cheque', array('states' => $states,
            'countries' => $countries, 'attendees' => $attendees, 'profile' => $profile));
    }

    public function createChequePayment(Request $request){
        $params = $request->all();
        // validate
        $rules = array(
            'seminar_name' => 'required',
            'seminar_date' => 'required',
            'provider_name' => 'required',
            'npi'      => 'required',
            'ptan' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'check_amount' => 'required',
            'check_number' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);


        // process the login
        if ($validator->fails()) {

            return Redirect::to('pay-by-cheque')
                ->withErrors($validator)
                ->withInput();
        } else {
            $cartTotal = $this->cartTotal;
            $discountTotal = $this->discount;
            $orderTotal = $cartTotal - $discountTotal;


            $order_id = Orders::saveOrder($this->user);
            Orders::orderPaymentSuccess($order_id,'check',$orderTotal);
            Orders::orderSuccess($order_id);
            $this->__singleSession($order_id);
            $this->__singleCourse($order_id);

            $attendees = array();
            if($this->cartCount){
                foreach ($this->cart as $key => $cartInfo){
                    $cartIntemInfo = Cart::instance('shopping')->get($key);
                    $getAssignTo = $cartIntemInfo->options->assignTo;
                    $attendees =  array_merge($attendees, $getAssignTo);
                }
                $order = Orders::find($order_id);
                $order->attendees = json_encode($attendees);
                $order->save();
            }




            Cart::instance('promo')->destroy();
            Cart::instance('shopping')->destroy();
            Cart::instance('bogo')->destroy();
            // store
            $cp = new ChequePayment();
            $cp->provider_name       = Input::get('provider_name');
            $cp->npi      = Input::get('npi');
            $cp->ptan = Input::get('ptan');
            $cp->address = Input::get('address');
            $cp->state = Input::get('state');
            $cp->phone = Input::get('phone');
            $cp->user_id = $this->user->id;
            $cp->order_id = $order_id;
            $cp->seminar_name = Input::get('seminar_name');
            $cp->seminar_date = date('Y-m-d 00:00:00', strtotime(Input::get('seminar_date')));
            $cp->check_number = Input::get('check_number');
            $cp->check_amount = Input::get('check_amount');

            $cp->save();

            // redirect
            #Session::flash('message', '');
            return Redirect::to('/thank-you');
        }
    }

    public function downloadPDF($id){
        $getRecentOrder = Orders::where('id', '=', $id)->first();

        $getRecentOrderDetails = OrderDetails::select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();


        $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

        $billingDetails = ChequePayment::where('order_id',$getRecentOrder->id)->first();

        $order_details = DB::table('orders')
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.id', '=', $id)
            ->lists('order_details.id');

        $attendees = array();
        if(is_array($order_details) && !empty($order_details)){
            $attendees = DB::table('course_assign')
                ->whereIn('order_detail_id', $order_details)
                ->get();
        }

        $check_payment_details = ChequePayment::where('order_id', '=', $id)->first();

        $user = User::find($getRecentOrder->user_id);

        $getPromos = array();

        $pdf = PDF::loadView('pdf',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'billingDetails'=>$billingDetails, 'attendees' =>$attendees, 'check_payment_details' => $check_payment_details, 'user' => $user]);

        return $pdf->download('invoice.pdf');

        //return View::make('pdf',['orderInfo'=>$getRecentOrder,'orderDetailInfo'=>$getRecentOrderDetails,'assigneeDetails'=>$getAssigneeDetails,'billingDetails'=>$billingDetails, 'attendees' =>$attendees, 'check_payment_details' => $check_payment_details, 'user' => $user]);

    }

    /*
     * Get PayPal payment Status
     */

    public function getPaymentStatus()

    {

        /** Get the payment ID before session clear **/

        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/

        Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            \Session::put('error','Payment failed');

            return Redirect::route('show.cart');

        }

        $payment = Payment::get($payment_id, $this->_api_context);

        /** PaymentExecution object includes information necessary **/

        /** to execute a PayPal account payment. **/

        /** The payer_id is added to the request query parameters **/

        /** when the user is redirected from paypal back to your site **/

        $execution = new PaymentExecution();

        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/

        $result = $payment->execute($execution, $this->_api_context);

        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        $order_id = Orders::saveOrder($this->user);
        if ($result->getState() == 'approved') {

            $cartTotal = $this->cartTotal - $this->discount;

            //save order to order table


            $this->__singleSession($order_id);
            $this->__singleCourse($order_id);

            Orders::orderSuccess($order_id);
            Orders::orderPaymentSuccess($order_id,$payment_id,$cartTotal);

            Cart::instance('promo')->destroy();
            Cart::instance('shopping')->destroy();
            Cart::instance('bogo')->destroy();


            /** it's all right **/

            /** Here Write your database logic like that insert record or value in database if you want **/

            \Session::put('success','Payment success');

            return Redirect::route('payment.thankyou');

        }

        \Session::put('error','Payment failed');

        return Redirect::route('show.cart');

    }

}
