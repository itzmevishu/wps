<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use App\Models\Catalog;
use App\Models\FreeFAM;
use App\Models\SubCategoryLU;
use App\Models\Category;
use App\Models\CategoryCourse;

use App\Http\Controllers\Controller;
use App\Functions\litmosAPI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Form;
use File;
use View;
use Auth;
use App;
use Cart;
use DB;

class CourseController extends Controller {


    public function __construct()
    {
        if(Auth::check() === false){
            Cart::instance('promo')->destroy();
            Cart::instance('shopping')->destroy();
            Cart::instance('bogo')->destroy();
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function catalogSearch(Request $request)
    {
        
        $input=$request->all();

        //return $input;

        $rules = [
                'search_terms' => 'required|string'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            //return $messages;

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('store-catalog')->withInput()->withErrors($validator);

        }


        $availableCourses = Catalog::where('active',1)->whereRaw("MATCH(name, description, 	ecommerce_short_description, ecommerce_long_description ) AGAINST ('".$input['search_terms']."' IN BOOLEAN MODE)")->orderBy('name')->paginate(8);

        //dd($availableCourses);

         if(Auth::check()){
            $userAuth= Auth::user();
            
         }

        return View::make('welcome',['courses'=>$availableCourses, 'searchTerm' =>$input['search_terms']]);
    }

    public function getCourses(Request $request)
    {
        $availableCourses = Catalog::where('active',1)
                                    ->where('for_sale', 1)
                                    ->where('litmos_deleted', 0)
                                    ->orderBy('name')->paginate(8);

         if(Auth::check()){
            $userAuth= Auth::user();

         }

        return View::make('welcome',['courses'=>$availableCourses, 'searchTerm' =>'']);
    }

    public function catalogSubCategory(Request $request, $parentName, $childName, $childId){

        $level  = Category::where('id',$childId)->value('level');
        if($childName == 'all' && $childId == 'all'){
            $category_id = Category::where('name',$parentName)->value('id');
            $getSubCatCourses = CategoryCourse::select('catalog_id')->where('category_id', $category_id)->get();
        }elseif($childId == 'all'){
            $category_id = Category::where('name',$childName)->value('id');
            $childIds  = Category::where('parent_id',$category_id)->pluck('id');
            $getSubCatCourses = CategoryCourse::select('catalog_id')->where('category_id', $category_id)->get();
        } else {
            $getSubCatCourses = CategoryCourse::select('catalog_id')->where('category_id', $childId)->get();
        }
        $availableCourses = Catalog::where('active',1)->whereIn('id',$getSubCatCourses)->orderBy('name')->paginate(8);

        return View::make('courses.subcategory-view',['courses'=>$availableCourses,'parentName'=>$parentName,'childName'=>$childName]);
    }

    public function catalogFreeCourses(Request $request){
        $availableCourses = Catalog::where('active',1)->where('z_price',0)->orderBy('litmos_title')->paginate(8);

        return View::make('courses.subcategory-view',['courses'=>$availableCourses,'free'=>true]);
    }

    public function getFreeFAMCourses()
    {
        $userAuth= Auth::user();
        
        //make sure user should be seeing this page
        $checkFAM = FreeFAM::where('user_id',$userAuth->id)->where('catalog_id',NULL)->where('active',1)->first();
        //return $checkFAM;

        if(! $checkFAM){
             return Redirect::to('/store-catalog')->with('errormsg','You have already chosen your free course. For questions, please contact Altec Sentry at 205.408.8260');
        }

        $availableCourses = Catalog::where('active',1)->where('litmos_sku','like','%-FAM-%')->orderBy('litmos_title')->paginate(8);

        return View::make('courses.choose-free-course',['courses'=>$availableCourses]);
    }

    public function assignCourse(Request $request)
    {
         $countries = Country::lists('country','country');

        $timeZoneList = [

            'Eastern Standard Time'=>'Eastern Timezone',
            'Central Standard Time'=>'Central Timezone',
            'Mountain Standard Time' => 'Mountain Timezone',
            'Pacific Standard Time' => 'Pacific Timezone',
            'Alaskan Standard Time'=>'Alaskan Timezone',
            'Hawaiian Standard Time' => 'Hawaiian Timezone'
        ];
        return View::make('courses.assign-course',['countries'=>$countries,'timeZones'=>$timeZoneList]);
        
    }

    public function confirmCourses(Request $request)
    {
        $input = $request->all();

        $session_id = (isset($input['sid'])) ? $input['sid']: null;

        if ($input['courseid'] == '' ){
            return Redirect::to('/welcome');
        }

        $checkCatalog = Catalog::where('course_id','=',$input['courseid'])->where('active','=',1)->first();


        $image_file =  $checkCatalog['image'];

        $getCourseIDResponse = litmosAPI::apiLitmosCourseID($checkCatalog['course_id']);
        if(empty($checkCatalog)){
            return Redirect::to('/course-not-found');
        }



        $free_course = false;
        /*$bogo = App\Models\Bogo::where('course_id', $checkCatalog['id'])->first();

        if(!empty($bogo)){
          $free_course = Catalog::where('id',$bogo->course_id_offered)->first();
        } else {
            $free_course = false;
        }*/

        if (empty($getCourseIDResponse)){
            return Redirect::to('/course-not-found');
        }



        if ($getCourseIDResponse->Active && $getCourseIDResponse->ForSale){


            $courseID = $getCourseIDResponse->Id;

            $z_info = Catalog::where('course_id',$input['courseid'])->first();

            //getCurrency = Currency::where('currency_type',$userAuth['curr_type'])->first();
            //$currency_rate = $getCurrency['rate'];
            $currency_rate = 1;
            //return $currency_rate;
           // if($currency_rate != '')
                //$z_eur_price =($coursePrice * $currencyRate);
            //else{
                $z_price =$z_info->price;
            //}

            //return $getCurrency;

            $z_price = number_format($z_price, 2, '.', '');
            $sessionResponse = litmosAPI::apiCheckIfSession($input,$courseID);
            $courseResponse = litmosAPI::apiGetSingleCourse($input,$courseID);

            $cart = Cart::content();

            //return $input;

            if (empty($sessionResponse)){
                return View::make('courses.confirm-course',['courseInfo'=>$courseResponse,'currencyRate'=>$currency_rate,'coursePrice'=>$z_price,'z_info'=>$z_info,'courseImage'=>$image_file, 'free_course' => $free_course, 'session_id' => $session_id]);
            }else{
                return View::make('courses.view-sessions',['cart'=>$cart,'moduleInfo'=>$sessionResponse,'currencyRate'=>$currency_rate,'courseInfo'=>$courseResponse,'input'=>$input,'coursePrice'=>$z_price,'z_info'=>$z_info,'courseImage'=>$image_file, 'free_course' => $free_course, 'session_id' => $session_id]);
            }
        }else{
            return Redirect::to('/course-not-found');
        }
    }

    
}
