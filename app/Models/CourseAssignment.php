<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_assign';

    public static function saveNewUserAssignments($assignArray,$litmosid,$orderdetailid,$success){
        $orderDetails = new CourseAssignment;
        $orderDetails->first_name=$assignArray['firstname'];
        $orderDetails->last_name=$assignArray['lastname'];
        $orderDetails->litmos_id=$litmosid;        
        $orderDetails->order_detail_id = $orderdetailid;
        $orderDetails->type=$assignArray['assign'];
        $orderDetails->username = $assignArray['litmosusername'];
        $orderDetails->success=$success;
        $orderDetails->save();
    }

    public static function saveExistingUserAssignments($type,$litmosid,$firstname,$lastname,
        $username,$orderdetailid,$success,$companyname){
        $orderDetails = new CourseAssignment;
        $orderDetails->first_name=$firstname;
        $orderDetails->last_name=$lastname;
        $orderDetails->litmos_id=$litmosid;
        $orderDetails->order_detail_id = $orderdetailid;
        $orderDetails->type=$type;
        $orderDetails->username = $username;
        $orderDetails->success=$success;
        $orderDetails->save();
    }

    public static function updateExistingUserAssignments($type,$litmosid,$firstname,$lastname,
        $username,$companyname,$seatid){
        $orderDetails = CourseAssignment::find($seatid);
        $orderDetails->type=$type;
        $orderDetails->litmos_id=$litmosid;
        $orderDetails->first_name=$firstname;
        $orderDetails->last_name=$lastname;
        $orderDetails->username = $username;
        $orderDetails->save();
    }
    
    //public static $table = 'plans';

}