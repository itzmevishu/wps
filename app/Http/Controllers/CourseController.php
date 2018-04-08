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
use Cache;
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

        if (isset($input['courseid']) && $input['courseid'] == '' ){
            return Redirect::to('/welcome');
        }
        $course_id = $input['courseid'];
        $courseInfo = Catalog::where('course_id','=',$course_id)->where('active','=',1)->first();

        if(empty($courseInfo)){
            return Redirect::to('/course-not-found');
        }

        $image_file =  $courseInfo['image'];

/*        if (Cache::has("getCourseIDResponse_$course_id")){
            $courseInfo = Cache::get("getCourseIDResponse_$course_id");
        } else {
            $courseInfo = litmosAPI::apiLitmosCourseID($checkCatalog['course_id']);
            Cache::put("getCourseIDResponse_$course_id", $courseInfo, 10);
        }*/



        $free_course = false;

        if ($courseInfo->active && $courseInfo->for_sale){


            $courseID = $courseInfo->course_id;
            $currency_rate = 1;
            $z_price =$courseInfo->price;

            $z_price = number_format($z_price, 2, '.', '');

            /*if (Cache::has("iltsessions_$course_id")){
                $sessionResponse = Cache::get("iltsessions_$course_id");
            } else {
                $sessionResponse = litmosAPI::apiCheckIfSession($input, $courseID);
                Cache::put("iltsessions_$course_id", $sessionResponse, 10);
            }*/
            $module_info = array();
            if(!empty($courseInfo->modules)) {
                $module_info = $courseInfo->modules;
            }

            /*if (Cache::has("course_$course_id")){
                $courseResponse = Cache::get("course_$course_id");
            } else {
                $courseResponse = litmosAPI::apiGetSingleCourse($input,$courseID);
                Cache::put("course_$course_id", $courseResponse, 10);
            }*/

            $cart = Cart::content();

            if (empty($module_info)){
                return View::make('courses.confirm-course',['courseInfo'=>$courseInfo,'currencyRate'=>$currency_rate,'coursePrice'=>$z_price,'z_info'=>$courseInfo,'courseImage'=>$image_file, 'free_course' => $free_course, 'session_id' => $session_id]);
            }else{
                return View::make('courses.view-sessions',['cart'=>$cart,'moduleInfo'=>$module_info,'currencyRate'=>$currency_rate,'courseInfo'=>$courseInfo,'input'=>$input,'coursePrice'=>$z_price,'courseImage'=>$image_file, 'free_course' => $free_course, 'session_id' => $session_id]);
            }
        }else{
            return Redirect::to('/course-not-found');
        }
    }

    
}
