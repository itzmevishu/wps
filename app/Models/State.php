<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class State extends Model{

    public static function getStateList(){
        $states = State::where('country','USA')->lists('name','abbreviation');

        return $states;
    }


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    //public static $table = 'plans';

}