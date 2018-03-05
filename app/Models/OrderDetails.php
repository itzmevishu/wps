<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_details';

    public function order() {
        return $this->belongsTo('Order');
    }

    public static function saveOrderDetails($orderID,$courseID,$courseSKU,$courseName,$moduleID,$moduleName,$sessionID,
                                            $sessionName,$location,$startDate,$endDate,$qty,$price){
        $orderDetails = new OrderDetails;
        $orderDetails->order_id=$orderID;
        $orderDetails->course_id=$courseID;
        $orderDetails->course_code=$courseSKU;
        $orderDetails->course_name=$courseName;
        $orderDetails->module_id=$moduleID;
        $orderDetails->module_name=$moduleName;
        $orderDetails->session_id=$sessionID;
        $orderDetails->session_name=$sessionName;
        $orderDetails->location=$location;
        $orderDetails->start_date=$startDate;
        $orderDetails->end_date=$endDate;
        $orderDetails->qty=$qty;
        $orderDetails->course_price=$price;
        $orderDetails->save();

        $orderDetailID = $orderDetails->id;

        return $orderDetailID;
    }
}