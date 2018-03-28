<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Functions\litmosAPI;
use App\Models\Catalog;
use App\Models\CourseModule;


class CourseSession extends Model
{
    //

    protected $table = 'course_sessions';

    protected $fillable = array('module_id', 'session_id', 'name', 'instructor_name', 'location', 'course_name', 'module_name', 'start_date',
        'end_date', 'slots', 'course_id');

    public static function saveSessions(){
        $result = litmosAPI::getFutureSessionList();

        foreach ($result as $key => $course){
            $lms_course_id = $course->Id;
            $course_id = Catalog::where('course_id', $lms_course_id)->value('id');
            foreach ($course->Modules as $moduleInfo){
                if($course_id) {
                    $lms_module_info = CourseModule::where('lms_module_id', $moduleInfo->Id)->first();

                    if (empty($lms_module_info)) {
                        $module = CourseModule::create([
                            'course_id' => $course_id,
                            'lms_module_id' => $moduleInfo->Id,
                            'name' => $moduleInfo->Name,
                            'description' => $moduleInfo->Description]);
                        $module_id = $module->id;
                    } else {
                        $module_id = $lms_module_info->id;
                        CourseModule::where('id', $module_id)
                            ->update([
                                'course_id' => $course_id,
                                'lms_module_id' => $moduleInfo->Id,
                                'name' => $moduleInfo->Name,
                                'description' => $moduleInfo->Description]);
                    }

                    // Insert ILT Sessions

                    $lms_course_sessions = $moduleInfo->Sessions;
                    foreach ($lms_course_sessions as $sessionInfo){

                        $wps_session_id = CourseSession::where('session_id', $sessionInfo->Id)->value('id');
                        if(!$wps_session_id){
                            $wps_session = CourseSession::create([
                                'module_id' => $module_id,
                                'course_id' => $lms_course_id,
                                'session_id' => $sessionInfo->Id,
                                'name' => $sessionInfo->Name,
                                'instructor_name' => $sessionInfo->InstructorName,
                                'location' => $sessionInfo->Location,
                                'course_name' => $sessionInfo->CourseName,
                                'module_name' => $sessionInfo->ModuleName,
                                'start_date' =>  self :: formatDate($sessionInfo->StartDate),
                                'end_date' =>  self :: formatDate($sessionInfo->EndDate),
                                'slots' => ($sessionInfo->Slots)? $sessionInfo->Slots : 0
                            ]);
                        } else {
                            CourseSession::where('id', $wps_session_id)
                                ->update([
                                    'module_id' => $module_id,
                                    'course_id' => $lms_course_id,
                                    'session_id' => $sessionInfo->Id,
                                    'name' => $sessionInfo->Name,
                                    'instructor_name' => $sessionInfo->InstructorName,
                                    'location' => $sessionInfo->Location,
                                    'course_name' => $sessionInfo->CourseName,
                                    'module_name' => $sessionInfo->ModuleName,
                                    'start_date' =>  self :: formatDate($sessionInfo->StartDate),
                                    'end_date' =>  self :: formatDate($sessionInfo->EndDate),
                                    'slots' => ($sessionInfo->Slots)? $sessionInfo->Slots : 0
                                ]);
                        }
                    }

                }
            }
        }
    }


    private static function formatDate($date){
        //$date = strstr(filter_var($date, FILTER_SANITIZE_NUMBER_INT), '-', true);
        preg_match( '/\/Date\((\d+)/', $date, $startDate );

        return  date("Y-m-d H:m:s",(string)floor($startDate[1]/1000));

    }

    /**
     * Get theco record associated with the session.
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Catalog', 'course_id', 'course_id');
    }

    public function scopeName($query, $name)
    {
        if ($name != 'all' && strtotime($name) === false) {
            $query->where('name', 'LIKE', "%$name%");
            $query->orWhere('location', 'LIKE', "%$name%");
        }
    }

    public function scopeDate($query, $date)
    {
        if (strtotime($date) !== false) {
            $query->where('start_date','>=',date('Y-m-d 00:00:00', strtotime($date)));
            $query->where('end_date','<=',date('Y-m-d 23:59:59', strtotime($date)));
        }
    }

}
