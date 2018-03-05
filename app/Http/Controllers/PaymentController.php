<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Crypt;
use Form;
use DB;
use Mail;
use Session;
use View;
use App\Models\Paypal;
class PaymentController extends Controller
{
    //

     public function checkout(Request $request) 
     {


           // get your logged in customer
           $customer = Auth::user();
           $clientToken = \Braintree_ClientToken::generate();
           
           return view('payment.checkout', array(
              'braintree_customer_id' => $customer->braintree_customer_id,
              'clientToken' => $clientToken
           ));
     }




     function getAccessToken(Request $request){

         #Connect to paypal and get access token
         $result = Paypal::authorize();
         return response()->json($result);

     }


     function pay_amount($access_token)
     {
        $paypal = new Paypal();
        $amount = '5.89';
        $result = $paypal->pay_amount($access_token, $amount);
        return response()->json($result);

     }
    
}
