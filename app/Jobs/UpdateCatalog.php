<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Functions\litmosAPI;
use App\Models\Catalog;
use App\Models\CourseSession;
use DB;

class UpdateCatalog extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     *
     * @return void
     */
    public function handle()
    {
        $limit = 500;
        $start = 0;
        $active_courses = array();
        while($limit > 0){

            $getCourses = litmosAPI::getUserCourses($limit,$start);

            if(!is_array($getCourses) && empty($getCourses)){
               return false;
            }

            foreach($getCourses as $course) {

                $checkProduct = Catalog::where('course_id',$course->Id)->first();

                # Storing Litmos API data as per new columns created.
                # Columns are associated with Litmos result fields
                if($checkProduct){
                    $item = Catalog::find($checkProduct['id']);
                }else{
                    $item = new Catalog;
                    $item->image = 'http://via.placeholder.com/200x200';
                }

                $item->course_id = $course->Id;
                $item->code = $course->Code;
                $item->name = $course->Name;
                $item->for_sale = $course->ForSale;
                $item->original_id = $course->OriginalId;
                $item->description = $course->Description;
                $item->ecommerce_short_description = $course->EcommerceShortDescription;
                $item->ecommerce_long_description = $course->EcommerceLongDescription;
                $item->price = $course->Price;
                $item->access_till_date = $course->AccessTillDate;
                $item->course_code_for_bulk_import = $course->CourseCodeForBulkImport;

                if($course->ForSale && $course->Active){
                    $item->active = $course->Active;
                }else{
                    $item->active = 0;
                }

                $item->save();

                $active_courses[] = $course->Id;
            }

            if(count($getCourses) > 0){
                $start = $start + count($getCourses);
            }else{
                $limit = 0;
            }

        }


        $allCourses = $titles = DB::table('catalog')->pluck('course_id');
        $inactive_course = array_diff($allCourses, $active_courses);
        DB::table('catalog')->whereIn('course_id', $inactive_course)->update(array('litmos_deleted' => true));

        CourseSession::saveSessions();
    }


}
