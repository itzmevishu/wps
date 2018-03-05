<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryCourse extends Model
{
    protected $table = 'category_courses';
    protected $fillable = array('category_id', 'catalog_id');
}
