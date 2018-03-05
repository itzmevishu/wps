<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dropdowns';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    public static function generateDropdown($dropdown_category_id) {
        $dropdown = array();
        $dropdown_options = Dropdown::where('category_id', '=', $dropdown_category_id)->get();
        foreach($dropdown_options as $dropdown_option) {
            $dropdown[$dropdown_option->option_name] = $dropdown_option->option_name;
        }
        return $dropdown;
    }

    public static function getByCategoryIdAndOptionName($category_id, $option_name) {
        return Dropdown::where(array('category_id' => $category_id, 'option_name' => $option_name))->first();
    }

}
