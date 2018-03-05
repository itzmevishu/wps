<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';


    /**
     * Get the Order details associated with the Order
     */
    public function order_details()
    {
        return $this->hasOne('App\Models\OrderDetails', 'order_id');
    }


    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    //public static $table = 'plans';

    public static function saveOrder($userAuth){
        $order = new Orders;
        $order->user_id=$userAuth['id'];
        $order->success=0;
        $order->save();

        $orderID = $order->id;

        return $orderID;


    }

    public static function orderPaymentSuccess($orderid,$paymentId,$orderTotal){
        $order = Orders::find($orderid);
        $order->payment_id=$paymentId;
        $order->order_total=$orderTotal;
        $order->save();
    }

    public static function orderSuccess($orderid){
        $order = Orders::find($orderid);
        $order->success=1;
        $order->save();
    }

}