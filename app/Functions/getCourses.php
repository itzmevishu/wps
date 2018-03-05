<?php

namespace App\Functions;
use DB;
use Log;

use App\Models\Catalog;
use App\Models\Tokens;
use App\Functions\litmosAPI;


class getCourses {

    public static function runUpdate()
    {
        $limit = 500;
        $start = 0;

        while($limit > 0){

            $getCourses = litmosAPI::getUserCourses($limit,$start);

            //dd($getCourses);

            foreach($getCourses as $course) {

                $checkProduct = Catalog::where('litmos_id',$course->Id)->first();

                if($checkProduct){
                    $item = Catalog::find($checkProduct['id']);
                    $item->litmos_id = $course->Id;
                    $item->litmos_price = $course->Price;
                    $item->litmos_title = $course->Name;
                    $item->litmos_shortDesc = $course->Description;
                    $item->litmos_keywords = $course->EcommerceShortDescription;
                    if($course->ForSale && $course->Active){
                        $item->active = $course->Active;
                    }else{
                        $item->active = 0;
                    }
                    $item->image = $course->OriginalId;
                    $item->save();

                    //DB::update("update ecomm_catalog set active = 0 where lms_course_id = '".$course->Id."'");
                }else{
                    if($course->ForSale && $course->Active) {
                        $item = new Catalog;
                        $item->litmos_id = $course->Id;
                        $item->litmos_price = $course->Price;
                        $item->litmos_title = $course->Name;
                        $item->litmos_shortDesc = $course->Description;
                        $item->litmos_keywords = $course->EcommerceShortDescription;
                        if($course->ForSale && $course->Active){
                            $item->active = $course->Active;
                        }else{
                            $item->active = 0;
                        }
                        $item->image = $course->OriginalId;
                        $item->save();
                    }
                }

               
            }

            if(count($getCourses) > 0){
                $start = $start + count($getCourses);
            }else{
                $limit = 0;
            }

        }
        
    }
   
}

