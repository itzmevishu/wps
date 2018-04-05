<?php
/**
 * Created by PhpStorm.
 * User: irodela
 * Date: 3/16/2015
 * Time: 9:46 AM
 */

namespace App\Functions;

use App\Models\PromoCourse;
use App\Models\Promo;
use App\Models\Orders;
use App\Models\OrderDetails;

use Cart;
use Log;
use Mail;
use Auth;
use DB;
use Redirect;


class helpers {


    public static function promoCheck(){

        $promos = Cart::instance('promo')->content();
        $discount_total = 0;

        foreach ($promos as $promo) {

            $check_promo = Promo::getSinglePromos($promo['id']);
            //get promo qty (may be empty)
            $promo_qty = $check_promo->promo_qty;

            if($check_promo){
                //single product promo
                if($promo['options']['type'] == 2){
                    $sale_product = PromoCourse::where('promo_id',$promo['id'])->first();
                    $item_row = Cart::instance('shopping')->search(array('id' => $sale_product['course_id']));

                    //if item exists, get the price of the item
                    if($item_row) {
                        $get_item = Cart::instance('shopping')->get($item_row[0]);

                        //if $promo_qty is not null, make sure product qty is correct
                        if($promo_qty == ''){
                            $cartQty = $get_item['qty'];
                        }else{
                             if($get_item['qty'] >= $promo_qty){
                                $cartQty = $promo_qty;
                            }else{
                                $cartQty = 0;
                            }
                        }
                       

                        //calculate the dollar off for all quantities
                        if ($check_promo->promo_dollar_off && $check_promo->promo_apply_to == 'items') {
                            $discount_total = $check_promo->promo_amount * $get_item['qty'];

                            //calculate the dollar off for the cart
                        } elseif ($check_promo->promo_dollar_off && $check_promo->promo_apply_to == 'cart') {
                            $discount_total = $check_promo->promo_amount;

                            //calculate the percent off for all quantities
                        } elseif ($check_promo->promo_percent_off) {
                            $discount_total = ($get_item['subtotal'] * ($check_promo->promo_amount/100));
                        }
                        
                        
                    }

                //collection or group of products
                }elseif($promo['options']['type'] == 3){

                    
                    //get product id
                    $sale_products = PromoCourse::where('promo_id',$promo['id'])->get();

                    foreach($sale_products as $sale_product){
                        //get row id if in cart
                        $item_row = Cart::instance('shopping')->search(array('id' => $sale_product['course_id']));

                        //if item exists, get the price of the item
                        if($item_row){
                            $get_item = Cart::instance('shopping')->get($item_row[0]);

                            $item_price = $get_item['price'];

                            //var_dump($item_price);

                            //if $promo_qty is not null, make sure product qty is correct
                            if($promo_qty == ''){
                                $cartQty = $get_item['qty'];
                            }else{
                                 if($get_item['qty'] >= $promo_qty){
                                    $cartQty = $promo_qty;
                                   //var_dump($cartQty);
                                }
                            }

                            //calculate the discount for all quantities
                            if($check_promo->promo_dollar_off==1 && $check_promo->promo_apply_to == 'items'){
                                $discount_total = $discount_total + ($check_promo->promo_amount * $cartQty);
                                 

                                //calculate the discount for cart
                            }elseif($check_promo->promo_dollar_off==1 && $check_promo->promo_apply_to == 'cart'){
                                $discount_total = $check_promo['promo_amount'];

                            }elseif($check_promo->promo_percent_off==1){
                               // var_dump($discount_total);
                                //$discount_total = $discount_total + ($get_item['subtotal'] * ($check_promo->promo_amount/100));
                                $discount_total = $discount_total +(($cartQty*$item_price) * ($check_promo->promo_amount/100));
                            } 



                        }
                    }


                }elseif($promo['options']['type'] == 1){

                    $cartTotal = Cart::instance('shopping')->total();

                    //calculate the discount
                    if($check_promo->promo_dollar_off){
                        $discount_total =$check_promo->promo_amount;

                    }elseif($check_promo->promo_percent_off){
                        $discount_total = ($cartTotal * ($check_promo->promo_amount/100));
                    }

                    
                }

                //dd($discount_total);
                Cart::instance('promo')->update($promo['rowid'],['price'=>$discount_total]);
            }

        }

    }


    public static function removePromoCheck()
    {

        Log::info('hit promo add to cart check');
        $discounts = Cart::instance('promo')->content();

        foreach ($discounts as $discount){

            Log::info('type'.$discount['options']['type']);
            Log::info('promoid'.$discount['id']);

            $sale_products = PromoCourse::where('promo_id',$discount['id'])->get();
            $check_promo = Promo::getSinglePromos($discount['id']);
            $item_exists = true;
            $itemCount = count($sale_products);
            $itemCountNeeded = 0;
            $qtyCount = 0;

            //get promo qty (may be empty)
            $promo_qty = $check_promo->promo_qty;

            //get row id if in cart
            foreach($sale_products as $product){
                $item_row = Cart::instance('shopping')->search(array('id' => $product['course_id']));                

                if($item_row){

                    $get_item = Cart::instance('shopping')->get($item_row[0]);
                    $item_exists = true;
                    $itemCountNeeded = $itemCountNeeded+1;

                    if($promo_qty != ''){
                        if($get_item['qty'] >= $promo_qty){
                            $qtyCount = $qtyCount +1;
                        }
                    }

                    //break;
                }else{
                    $item_exists = false;

                    $itemCountNeeded = $itemCountNeeded+1;
                }
            }

            if($check_promo->promo_all_products_req){
                if($itemCountNeeded != $itemCount){
                    Cart::instance('promo')->remove($discount['rowid']);
                    return Redirect::action('CartController@showCart')->with('message','Promo code  '.$check_promo->promo_code.' is valid but you do not have all applicable courses in your cart.');
                }

                if($promo_qty != ''){
                    if($qtyCount != $itemCount){

                       Cart::instance('promo')->remove($discount['rowid']);
                        return Redirect::action('CartController@showCart')->with('message','Promo code  '.$check_promo->promo_code.' is valid but you must purchase '.$check_promo->promo_qty.' seats of the required course(s).');
                    }
                }

             }else{
                if($itemCountNeeded == 0){
                    Cart::instance('promo')->remove($discount['rowid']);
                    return Redirect::action('CartController@showCart')->with('message','Promo code  '.$check_promo->promo_code.' is valid but you do not have any applicable courses in your cart.');
                }

                if($promo_qty != ''){
                    if($qtyCount == 0){

                       Cart::instance('promo')->remove($discount['rowid']);
                        return Redirect::action('CartController@showCart')->with('message','Promo code  '.$check_promo->promo_code.' is valid but you must purchase '.$check_promo->promo_qty.' seats of the required course(s).');
                    }
                }

            }

        }

    }


    public static function emailILTSession($courseName,$sessionName,$location,$startDate,$endDate,$firstName,$lastName,$emailAddress){
        
        $email_array = array('first_name'=>$firstName,'last_name'=>$lastName,'email'=>$emailAddress,'class_name'=>$sessionName,'course_name'=>$courseName,'class_start'=>$startDate,'class_end'=>$endDate,'location'=>$location);
        
        Mail::send('emails.iltConfirmation', $email_array, function ($message) use ($email_array) {
            $message->to($email_array['email'], $email_array['first_name'].' '.$email_array['last_name'])->subject('WPS Learning Center: '.$email_array['course_name'].' Enrollment');
        });
    }

    public static function emailOrderConfirmation($orderId){

        $userAuth= Auth::user();

        $getRecentOrder = Orders::where('id',$orderId)->where('success',true)->first();
        $getRecentOrderDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

        $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

        $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promos_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();


        $email_array = array(
            'orderInfo'=>$getRecentOrder,
            'orderDetailInfo'=>$getRecentOrderDetails,
            'emailName'=> $userAuth['first_name'].' '.$userAuth['last_name'],
            'emailAddress'=> $userAuth['username'],
            'assigneeDetails' =>$getAssigneeDetails,
            'promoDetails' =>$getPromos,
            'userInfo' =>$userAuth
        );
       
        Mail::send('emails.email-order', $email_array, function ($message) use ($email_array) {
            $message->to($email_array['emailAddress'], $email_array['emailName'])->subject('WPS Learning Center: Order Confirmation');
        });

    }


    public static function emailFreeOrderConfirmation($orderId){

        $userAuth= Auth::user();

        $getRecentOrder = Orders::where('id',$orderId)->where('success',true)->first();
        $getRecentOrderDetails = OrderDetails::distinct()->select('order_id', 'course_sku','course_name','qty','course_price')->where('order_id',$getRecentOrder->id)->get();

        $getAssigneeDetails = OrderDetails::where('order_id',$getRecentOrder->id)->get();

        $getPromos = DB::table('promos')->join('promos_used','promos.id','=','promos_used.promo_id')->where('promos_used.order_id',$getRecentOrder->id)->get();


        //return $getRecentOrder;

        $email_array = array(
            //'payment'=>$payment,
            'orderInfo'=>$getRecentOrder,
            'orderDetailInfo'=>$getRecentOrderDetails,
            'emailName'=> $userAuth['first_name'].' '.$userAuth['last_name'],
            'emailAddress'=> $userAuth['username'],
            'assigneeDetails' =>$getAssigneeDetails,
            'promoDetails' =>$getPromos
        );
       
        Mail::send('emails.email-order-free', $email_array, function ($message) use ($email_array) {
            $message->to($email_array['emailAddress'], $email_array['emailName'])->subject('WPS Learning Store: Order Confirmation');
        });
        

    }

    /*
     *  BOGO Feature
     *
     */

    public static function bogoCheck(){
        $cart = Cart::instance('shopping')->content();
        $cartTotal = Cart::instance('shopping')->total();
        $cartCount = Cart::instance('shopping')->count();
        Cart::instance('bogo')->destroy();
        $toal_price = 0;

        foreach ($cart as $cartDetail){
            $row_id = $cartDetail['rowid'];
            $course_id = $cartDetail['id'];
            $qty = $cartDetail['qty'];

            $price = $cartDetail['price'];
            $bogo_info = \App\Models\Catalog::where('course_id', $course_id)
                ->with('bogo')
                ->first();
                if(!is_null($bogo_info->bogo)) {
                    $offer_percentage = $bogo_info->bogo->offer;
                    $discount = 0;
                    if ($qty == 1) {
                        $discount = 0;
                        $toal_price += $price;
                    } elseif ($qty == 2 || $qty == 3) {
                        $num_of_courses = 1;
                        $discount = (($num_of_courses * $price) * ($offer_percentage / 100));
                        $toal_price += (($qty * $price) - $discount);
                    } elseif ($qty % 2 == 0) {
                        $num_of_courses = $qty - 2;
                        $discount = (($num_of_courses * $price) * ($offer_percentage / 100));
                        $toal_price += (($qty * $price) - $discount);
                    } else {
                        $num_of_courses = $qty - 1;
                        $discount = (($num_of_courses * $price) * ($offer_percentage / 100));
                        $toal_price += (($qty * $price) - $discount);
                    }

                    Cart::instance('bogo')->add(time(), time(), 1, $discount);
                }
        }


        //
    }


}

