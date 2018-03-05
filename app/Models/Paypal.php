<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 1/18/2018
 * Time: 7:01 AM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Paypal
{

    static function authorize(){
        $clientId = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);
        $json = json_decode($result);
        return $result;
    }


    function pay_amount($acess_token, $amount){


        $data = '{
              "intent":"sale",
              "redirect_urls":{
                "return_url":"http://139.59.86.32",
                "cancel_url":"http://139.59.86.32"
              },
              "payer":{
                "payment_method":"paypal"
              },
              "transactions":[
                {
                  "amount":{
                    "total":"'.$amount.'",
                    "currency":"USD"
                  },
                  "description":"This is the payment transaction description."
                }
              ]
            }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer $acess_token",
                "Content-length: " . strlen($data))
        );

        $result = curl_exec($ch);
        return $result;

    }
}