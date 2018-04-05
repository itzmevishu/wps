<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Catalog;
use App\Models\Country;
use App\Models\State;
use App\Models\Currency;
use App\Models\User;
use App\Models\Promo;
use App\Http\Controllers\Controller;
use App\Functions\litmosAPI;
use App\Functions\helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use View;
use Form;
use Cart;
use Auth;
use HTML;

class CartController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
   
   public function addToCart(Request $request)
    {
        $input = $request->all();

        $modSessionArray = [];

        $sessionDetails = '';
        $seatQty = '';
        $sessionPaypal = '';
        $sessionLocation = '';

        if($input['course_type'] == 'single session'){

            $moduleArray = explode(",",$input['module_array']);
            foreach($moduleArray as $module){

                $sessionInfo = litmosAPI::apiGetASession($input['course_id'],$module,$input['session_id_'.$module]);

                preg_match( '/\/Date\((\d+)/', $sessionInfo->StartDate, $startDate );
                preg_match( '/\/Date\((\d+)/',  $sessionInfo->EndDate, $endDate );

                array_push($modSessionArray,array(
                    'moduleid'=>$module,
                    'sessionid'=>$input['session_id_'.$module],
                    'session_name'=>$sessionInfo->Name,
                    'start_date'=>date( 'Y-m-d', $startDate[1]/1000 ),
                    'end_date'=>date( 'Y-m-d', $endDate[1]/1000 ),
                    'module_name'=>$sessionInfo->ModuleName,
                    'location' => $sessionInfo->Location
                    ));


                $sessionDetails .= '<strong>Dates:</strong> '.date( 'M d, Y', $startDate[1]/1000 ).' to '.date( 'M d, Y', $endDate[1]/1000 ).'<br>';
                $sessionDetails .= '<strong>Location:</strong> '.$sessionInfo->Location.'</p>';

                $sessionPaypal = $sessionInfo->Name.' ';

                $sessionLocation = $sessionInfo->Location;


                //echo $sessionDetails;

                $seats= $sessionInfo->Slots - $sessionInfo->Accepted;

                if($seatQty == ''){
                    $seatQty = $seats;
                }else{
                    if($seatQty > $seats){
                        $seatQty = $seats;
                    }
                }

            }
        }

        if($input['course_type'] == 'single course'){
            $moduleArray = '';

            $seatQty = 20;
            $sessionDetails ='';
            $sessionLocation = '';
            $sessionPaypal = $input['course_name'];
        }
        #Laravel Shoppingcart composer require gloudemans/shoppingcart
        $this->__addShoppingCart($input, $modSessionArray, $sessionDetails, $seatQty, $sessionPaypal, $sessionLocation);
        $freeCourseInput = $this->__freeCourse($input);
        if($freeCourseInput) {
            $this->__addShoppingCart($freeCourseInput, $modSessionArray, $sessionDetails, $seatQty, $sessionPaypal, $sessionLocation);
        }
        helpers::bogoCheck();
        helpers::promoCheck();
        if($request->ajax()){
            return array('count' => Cart::instance('shopping')->count());
        } else {
            return Redirect::action('CartController@showCart');
        }

    }

    public function showCart()
    {
        //Cart::instance('promo')->destroy();
        #Cart::instance('bogo')->destroy();
        $cart = Cart::instance('shopping')->content();
        $cartTotal = Cart::instance('shopping')->total();
        $cartCount = Cart::instance('shopping')->count();
        $bogo_discount = Cart::instance('bogo')->total();

        //dd($cart);

        $discount = Cart::instance('promo')->content();
        $discountTotal = Cart::instance('promo')->total();

        $checkPromos = Promo::getAvailablePromos();
        $cartTotal = number_format($cartTotal, 2, '.', '');

        if (Auth::check())
        {
            // The user is logged in...
            $userAuth = Auth::user();

        }

        /*
         *  WHY DO WE REQUIRE BELOW LOGIC NOW ?
         *  Vishal Kalappagari
         */

        helpers::promoCheck();

        //helpers::removePromoCheck();
        return View::make('cart.show-cart',['promos'=>$checkPromos,'discount'=>$discount,'discountTotal'=>$discountTotal,'cart'=>$cart,'currencyRate'=>'','cartTotal'=>$cartTotal,'cartCount'=>$cartCount, 'bogoDiscount' => $bogo_discount]);

    }

    public function removeFromCart(Request $request)
    {

        $input=$request->all();

        Cart::instance('shopping')->remove($input['rowid']);

        //run promo update
        helpers::promoCheck();
        helpers::removePromoCheck();

        return Redirect::action('CartController@showCart');
    }

    public function updateCart(Request $request)
    {

        $input=$request->all();

        $getCart = Cart::instance('shopping')->get($input['rowid']);
        $assignToCnt = count($getCart['options']['assignTo']);
        $getCartArray = $getCart->options->assignTo;

        if($input['qty'] > $assignToCnt){


            $assignCnt = $input['qty']-$assignToCnt;

            for($i = 0; $i < $assignCnt; $i++){

                array_push($getCartArray,array(
                    'assign'=>'',
                    'litmosid'=>'',
                    'litmosusername' =>'',
                    'firstname'=>'',
                    'lastname'=>'',
                    'company' => '',
                    'title' => '',
                    'street' => '',
                    'city' => '',
                    'state' => '',
                    'zip'=> '',
                    'workphone' => ''
                ));

            }

            //return $getCartArray;

        }else{
            $assignCnt = $assignToCnt - $input['qty'];

            for($i = 0; $i < $assignCnt; $i++) {

                array_pop($getCartArray);
            }



        }
        Cart::instance('shopping')->update($input['rowid'],array('qty'=>$input['qty'],'options'=>['assignTo'=>$getCartArray]));

        helpers::promoCheck();
        helpers::removePromoCheck();
        helpers::bogoCheck();
        return Redirect::action('CartController@showCart');
    }

    public function assignCourse(Request $request)
    {

        $input = $request->all();

        //return $input;

        if($input['assign'] == 'Assign To Other'){
            //$input['rowid']
            //$input['arraycnt']

            $rowInfo = Cart::instance('shopping')->get($input['rowid']);
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

            return View::make('cart.assign-user',['show'=>$input['show'],'timeZones'=>$timeZoneList,'states'=>$states,'countries'=>$countries,'rowid'=>$input['rowid'],'arraycnt'=>$input['arraycnt'],'rowinfo'=>$rowInfo]);


        }else{
            $getAssignTo = Cart::instance('shopping')->get($input['rowid']);

            $getAssignTo = $getAssignTo->options->assignTo;

            $getAssignTo[$input['arraycnt']]['assign'] = 'self';
            $getAssignTo[$input['arraycnt']]['litmosid'] = $input['litmos_id'];
            $getAssignTo[$input['arraycnt']]['firstname'] = $input['first_name'];
            $getAssignTo[$input['arraycnt']]['lastname'] = $input['last_name'];
            $getAssignTo[$input['arraycnt']]['litmosusername'] = $input['email'];
            $getAssignTo[$input['arraycnt']]['company'] = $input['company'];

            Cart::instance('shopping')->update($input['rowid'], ['options'=>array('assignTo'=>$getAssignTo)]);

            return Redirect::action('CheckoutController@stepOne');
        }


    }

    public function assignExistingUserToCourse(Request $request)
    {

        $input=$request->all();


        //return $input;


            $getAssignTo = Cart::instance('shopping')->get($input['rowid']);

            $getAssignTo = $getAssignTo->options->assignTo;


            $getAssignTo[$input['arraycnt']]['assign'] = 'existing';
            $getAssignTo[$input['arraycnt']]['litmosid'] = $input['litmosid'];
            $getAssignTo[$input['arraycnt']]['firstname'] = $input['firstname'];
            $getAssignTo[$input['arraycnt']]['lastname'] = $input['lastname'];
            $getAssignTo[$input['arraycnt']]['litmosusername'] = $input['email'];

            Cart::instance('shopping')->update($input['rowid'], ['options'=>array('assignTo'=>$getAssignTo)]);

            return Redirect::action('CheckoutController@stepOne');

    }

    public function assignNewUserToCourse(Request $request)
    {

        $input = $request->all();
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users'
        ];


        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/assign-course?show=1&assign=Assign To Other&rowid='.$input['rowid'].'&arraycnt='.$input['arraycnt'])->withInput()->withErrors($validator);

        }

        //create user here
        $newUserArray = litmosAPI::createUserArray($input, false, 'learner', true, false, true, 'wpsLc@123');
        $userCreateRequest = litmosAPI::apiUserCreate($newUserArray, 'true');

        $requestCode = $userCreateRequest->getStatusCode();


        if ($requestCode == 201) {

            //get response
            $createJson = json_decode($userCreateRequest->getBody());

            $getAssignTo = Cart::instance('shopping')->get($input['rowid']);

            $getAssignTo = $getAssignTo->options->assignTo;

            $getAssignTo[$input['arraycnt']]['assign'] = 'existing';
            $getAssignTo[$input['arraycnt']]['litmosid'] = $createJson->Id;
            $getAssignTo[$input['arraycnt']]['firstname'] = $input['first_name'];
            $getAssignTo[$input['arraycnt']]['lastname'] = $input['last_name'];
            $getAssignTo[$input['arraycnt']]['litmosusername'] = $input['email'];

            Cart::instance('shopping')->update($input['rowid'], ['options'=>array('assignTo'=>$getAssignTo)]);

            return Redirect::action('CheckoutController@stepOne');

        }

    }


    function __addShoppingCart($input, $modSessionArray, $sessionDetails, $seatQty, $sessionPaypal, $sessionLocation){
        Cart::instance('shopping')->add($input['course_id'], $input['course_name'], 1, $input['course_price'],
            array(
                'sessionmod' => $modSessionArray,
                'assignTo'=>[array(
                    'assign'=>'',
                    'litmosid'=>'',
                    'litmosusername' =>'',
                    'firstname'=>'',
                    'lastname'=>'',
                    'company' => '',
                    'title' => '',
                    'street' => '',
                    'city' => '',
                    'state' => '',
                    'zip'=> '',
                    'workphone' => ''
                )],
                'type' => $input['course_type'],
                'course_details' => $sessionDetails,
                'seats_available' => $seatQty,
                'paypal_details' => $sessionPaypal,
                'course_sku' =>$input['course_sku'],
                'course_name'=>$input['course_name'],
                'location' => $sessionLocation
            ));
    }



    function __freeCourse($input){
            if($input['free_course'] == 0){
                return false;
            }
            $free_course_id = $input['free_course'];
            $courseInfo = Catalog::find($free_course_id);
            $input['course_id'] = $courseInfo->course_id;
            $input['course_name'] = $courseInfo->name;
            $input['course_sku'] = $courseInfo->course_code_for_bulk_import;
            $input['course_price'] = 0;
            return $input;
    }

}
