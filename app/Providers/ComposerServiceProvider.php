<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\CategoryLU;
use App\Models\SubCategory;
use App\Models\SubCategoryLU;
use Auth;
use Cart;
use DB;
use Request;
use Cache;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            $view->with(['site_name'=>'psdemo','logo'=>'http://via.placeholder.com/200x75','custom_css_file'=>'/bootstrap/css/custom.css']);
        });


        view()->composer('layouts.default', function($view)
        {

            $cartCount = Cart::instance('shopping')->count();
            $userAuth= Auth::user();

            $getURL = Request::url();

            if (Cache::has('categories') && false){
                $result = Cache::get('categories');
            } else {
                $sql = 'select root.name  as root_name, down1.name as down1_name, down2.name as down2_name, down2.id as down2_id
                      from categories as root
                    left outer join categories as down1
                        on down1.parent_id = root.id
                    left outer join categories as down2
                        on down2.parent_id = down1.id
                     where root.parent_id is null
                    order 
                        by root.id 
                         , down1_name 
                         , down2_name';
                $result = \Illuminate\Support\Facades\DB::select($sql);

                Cache::put("categories", $result, 10);
            }




            $menu = $subItems = array();
            for ($i = 0; $i < count($result); $i++) {
                //if(in_array($result[$i]->down2_name, $subItems) === false){
                    //array_push($subItems, $result[$i]->down2_name);
                    if($result[$i]->down1_name != "") {
                        $menu[$result[$i]->root_name][$result[$i]->down1_name][] = array("id" => $result[$i]->down2_id, "name" => $result[$i]->down2_name);
                    } elseif($result[$i]->down1_name == "") {
                        $menu[$result[$i]->root_name] = $result[$i]->root_name;
                    }
                //}
            }

            $view->with(['cartCount'=>$cartCount,'userAuth'=>$userAuth,'getURL'=>$getURL,'menu' => $menu]);

        });

        view()->composer('welcome', function($view)
        {
            $userAuth= Auth::user();

            $view->with(['userAuth'=>$userAuth]);

        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}