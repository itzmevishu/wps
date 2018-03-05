<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropdownCategory extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dropdown_categories';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static function getDropdownCategoriesKeyedByName() {
        $categories = array();
        $dc = DropdownCategory::all();
        foreach($dc as $c) {
            $categories[$c->category_name] = $c->id;
        }
        return $categories;
    }
}
