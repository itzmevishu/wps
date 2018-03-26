<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Country;
use App\Models\User;
use App\Models\Promo;
use App\Models\PromoCourse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use View;
use Form;
use Cart;
use Auth;
use DB;
use App\Currency;

class PromoController extends Controller {
   
   public function addDiscount(Request $request)
    {
        $input=$request->all();

        $userAuth= Auth::user();

        $promo_code = $input['discount_code'];
        $promo_code = preg_replace('/\s+/', '', $promo_code);

        $cart = Cart::instance('shopping')->content();
        $cartTotal = Cart::instance('shopping')->total();

        $discounts = Cart::instance('promo')->content();

        //check to see if promo is valid.
        $check_promo = Promo::getPromoByCode($promo_code);

        

        //return $promo_code;

        //it exists and is active
        if($check_promo){
            //check if dates are good        

            if($check_promo->promo_start_dt > date('Y-m-d') ){
                
                return Redirect::action('CartController@showCart')->with('message','Promo code '.$promo_code.' is not available until '.$check_promo->promo_start_dt.'.');
                //return '<br> start date is in future for promo';
            }

            if(! $check_promo->promo_no_expiry && $check_promo->promo_end_dt < date('Y-m-d') ){
                
                return Redirect::action('CartController@showCart')->with('message','Promo code '.$promo_code.' has expired.');
                //return '<br> start date is in future for promo';
            }            

            //check if only use once
            if($check_promo->promo_single_use){
                //check if user has used this promo
                $customerPromos = DB::table('promo_used')->where('promo_id',$check_promo->id)
                    ->where('user_id',$userAuth['id'])->get();

                if(count($customerPromos) > 0){
                    return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' has already been used. This promo can only be used once per customer.');
                }
            }

            //check if user is already using this promo
            $promo_row = Cart::instance('promo')->search(array('id' =>$check_promo->id));

            if($promo_row){
                return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' has already been used. This promo can only be used once per order.');
            }




            //if not stackable...
            if(!$check_promo->promo_stackable){
                if(count($discounts) > 0){
                    return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' cannot be stacked with other promos.');
                }
            }else{
                if(count($discounts) > 0){

                    foreach($discounts as $discount){
                        $promoInfo = Promo::getSinglePromos($discount['id']);

                        if(!$promoInfo->promo_stackable){
                            return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' cannot be stacked with other promos.');
                        }
                    }

                }
            }

            //get promo qty (may be empty)
            $promo_qty = $check_promo->promo_qty;


            //single product promo
            if($check_promo->promo_type_id == 2){

                //get product id
                $sale_product = PromoCourse::where('promo_id',$check_promo->id)->first();

                //get row id if in cart
                $item_row = Cart::instance('shopping')->search(array('id' => $sale_product['course_id']));

                //if item exists, get the price of the item
                if($item_row){

                    $get_item = Cart::instance('shopping')->get($item_row[0]);
                    $item_total = $get_item['subtotal'];
                    $item_price = $get_item['price'];
                    
                    //if $promo_qty is not null, make sure product qty is correct
                    if($promo_qty != ''){
                        if($get_item['qty'] < $promo_qty){
                            return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' is valid but you must purchase '.$promo_qty.' seats of the required course(s).');
                        }

                        $cartQty = $promo_qty;

                    }else{
                        $cartQty = $get_item['qty'];
                    }                    

                    //calculate the discount for all quantities or if restricted, only for the qty of the promo
                    if($check_promo->promo_dollar_off == 1 && $check_promo->promo_apply_to == 'items'){
                        $item_discount_total = $check_promo->promo_amount * $cartQty;
                        Cart::instance('promo')->add($check_promo->id, $check_promo->promo_code, 1, $item_discount_total,['description'=>$check_promo->promo_desc,'type'=>2,'restriction'=>$promo_qty]);

                    //calculate the discount for cart
                    }elseif($check_promo->promo_dollar_off == 1 && $check_promo->promo_apply_to == 'cart'){
                        Cart::instance('promo')->add($check_promo->id, $check_promo->promo_code, 1, $check_promo->promo_amount,['description'=>$check_promo->promo_desc,'type'=>2,'restriction'=>$promo_qty]);

                    }elseif($check_promo->promo_percent_off == 1){
                        //dd($check_promo);
                        //$item_discount_total = ($item_total * ($check_promo->promo_amount/100));
                        $item_discount_total = (($cartQty*$item_price) * ($check_promo->promo_amount/100)); 
                        Cart::instance('promo')->add($check_promo->id, $check_promo->promo_code, 1, $item_discount_total,['description'=>$check_promo->promo_desc,'type'=>2,'restriction'=>$promo_qty]);
                    }

                    

                }else{
                    return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' is valid but you do not have valid courses in your cart.');
                }
            //collection or group of products
            }elseif($check_promo->promo_type_id == 3){

                //get product id
                $sale_products = PromoCourse::where('promo_id',$check_promo->id)->get();
                $getCollectionDiscount = 0;
                $itemCount = count($sale_products);
                $itemCountNeeded = 0;
                $qtyCount = 0;

                
                foreach($sale_products as $sale_product){
                    //get row id if in cart
                    $item_row = Cart::instance('shopping')->search(array('id' => $sale_product['course_id']));

                    //echo $item_row;

                    //if item exists, get the price of the item
                    if($item_row){
                        $get_item = Cart::instance('shopping')->get($item_row[0]);
                        $item_total = $get_item['subtotal'];
                        $item_price = $get_item['price'];
                        $itemCountNeeded = $itemCountNeeded+1;

                        if($promo_qty != ''){
                            if($get_item['qty'] >= $promo_qty){
                                $qtyCount = $qtyCount +1;
                                $cartQty = $promo_qty;

                            }else{
                                $cartQty = $get_item['qty'];
                            }                    
                        }else{
                            $cartQty = $get_item['qty'];
                        }

                        //calculate the discount for all quantities
                        if($check_promo->promo_dollar_off == 1 && $check_promo->promo_apply_to == 'items'){
                            $item_discount_total = $check_promo->promo_amount * $cartQty;
                            $getCollectionDiscount = $getCollectionDiscount + $item_discount_total;

                            //calculate the discount for cart
                        }elseif($check_promo->promo_dollar_off == 1 && $check_promo->promo_apply_to == 'cart'){
                            $getCollectionDiscount = $check_promo->promo_amount;

                        }elseif($check_promo->promo_percent_off == 1){
                            //$item_discount_total = ($item_total * ($check_promo->promo_amount/100));
                            $item_discount_total = (($cartQty*$item_price) * ($check_promo->promo_amount/100)); 
                            $getCollectionDiscount = $getCollectionDiscount + $item_discount_total;
                        }
                    }
                }

                if($check_promo->promo_all_products_req){
                    if($itemCountNeeded != $itemCount){

                       // return $itemCountNeeded;
                        return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' is valid but you do not have all applicable courses in your cart.');
                    }

                    if($promo_qty != ''){
                        if($qtyCount != $itemCount){

                           // return $itemCountNeeded;
                            return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' is valid but you must purchase '.$promo_qty.' seats of the required course(s).');
                        }
                    }

                }else{
                    if($itemCountNeeded == 0){
                        return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' is valid but you do not have any applicable courses in your cart.');
                    }

                    if($promo_qty != ''){
                        if($qtyCount == 0){

                           // return $itemCountNeeded;
                            return Redirect::action('CartController@showCart')->with('message','Promo code  '.$promo_code.' is valid but you must purchase '.$promo_qty.' seats of the required course(s).');
                        }
                    }
                }

                

                Cart::instance('promo')->add($check_promo->id, $check_promo->promo_code, 1, $getCollectionDiscount,['description'=>$check_promo->promo_desc,'type'=>3,'restriction'=>$promo_qty]);


            //cart discount
            }elseif($check_promo->promo_type_id == 1){

                //calculate the discount
                if($check_promo->promo_dollar_off){
                    //return 'hi44';
                    Cart::instance('promo')->add($check_promo->id, $check_promo->promo_code, 1, $check_promo->promo_amount,['description'=>$check_promo->promo_desc,'type'=>1,'restriction'=>$promo_qty]);

                }elseif($check_promo->promo_percent_off){
                    //return 'hi2';
                    $discount = ($cartTotal * ($check_promo->promo_amount/100));
                    Cart::instance('promo')->add($check_promo->id, $check_promo->promo_code, 1, $discount,['description'=>$check_promo->promo_desc,'type'=>1,'restriction'=>$promo_qty]);

                }

            }

        }else{
            return Redirect::action('CartController@showCart')->with('message','Promo code '.$promo_code.' is not available.');
        }

        return Redirect::action('CartController@showCart');
    }



    public function removeDiscount(Request $request)
    {

        $input=$request->all();

        Cart::instance('promo')->remove($input['rowid']);

        return Redirect::action('CartController@showCart');
    }







}
