<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bogo extends Model
{
    protected $table = 'bogos';

    protected $fillable = ['course_id', 'course_id_offered'];
}
