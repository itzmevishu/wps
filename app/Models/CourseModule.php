<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    protected $table = 'course_modules';

    protected $fillable = array('lms_module_id', 'course_id', 'name', 'description');
}
