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
                        ->where('litmos_deleted', 0)
                        ->orderBy('name')
                        ->lists( 'name', 'id');
    }


    /**
     * Get the post that the comment belongs to.
     */
    public function bogo()
    {
        return $this->hasOne(\App\Models\Bogo::class, 'course_id');
    }

    public function modules()
    {
        return $this->hasMany(\App\Models\CourseModule::class, 'course_id');
    }


}