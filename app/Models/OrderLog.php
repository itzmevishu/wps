<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class OrderLog extends Model
{
    protected $table = 'order_logs';
    protected $fillable = array('user_id','user_name','user_email','user_litmos_id','order_id','order_status',
        'order_payment_id','order_total','order_date','course_id','course_name','module_id','module_name', 'session_id',
        'session_name');


    public static function storePurchaseOrder(){

        $last_order_id = \App\Models\OrderLog::latest()->value('order_id');

        $last_order_id = ($last_order_id)? $last_order_id : 0 ;


        $orders = DB::table('orders')
            ->leftJoin('order_details as od', 'orders.id', '=', 'od.order_id')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.id' , '>', $last_order_id)
            ->orderBy('orders.id', 'ASC')
            ->select('users.id as user_id', 'users.name as user_name', 'users.email as user_email', 'users.litmos_id as user_litmos_id',
                    'orders.id as order_id', 'orders.success as order_status', 'orders.payment_id as order_payment_id', 'orders.order_total', 'orders.created_at as order_date',
                    'od.course_id','od.course_name', 'od.module_id', 'od.module_name', 'od.session_id', 'od.session_name')

            ->get();

        $orders = collect($orders)->map(function($x){ return (array) $x; })->toArray();

        if($orders) {
            $result = DB::table('order_logs')->insert($orders);
            dd($result);
        }
        return $orders;
    }
}
