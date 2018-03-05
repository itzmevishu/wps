<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalog';

    //public static $table = 'plans';

    public static function courses(){
        return Catalog::where('active',1)
                        ->where('for_sale', 1)
                        ->orderBy('name')
                        ->lists( 'name', 'id');
    }


}