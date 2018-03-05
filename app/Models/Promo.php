<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\RequestException;

use DB;

class Promo extends Model{

    public static function getAvailablePromos(){
        $availablePromos = DB::table('promos')->get();

        return $availablePromos;
    }


    public static function getSinglePromos($promoID){
        $availablePromos = DB::table('promos')->where('id',$promoID)->first();

        return $availablePromos;
    }

    public static function getPromoByCode($promoCode){
        $availablePromos = DB::table('promos')->where('promo_code',$promoCode)->where('promo_enable',1)->first();

        return $availablePromos;
    }


    protected $table = 'promos';

}