<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\CategoryLU;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use View;
use Form;
use Input;
use Session;



class CategoryController extends Controller {

	   

    public function showCategories(Request $request){

    	$getCategories = Category::where('level', 1)->get();

    	return View::make('admin.category.show-category',['categories'=>$getCategories]);
        
    }

    public function addCategory(Request $request){

    	$input=$request->all();

    	$saveCategory = new Category();
        $saveCategory ->name = $input['cat_name'];
        $saveCategory ->level = 1;
        $saveCategory->save();

        return Redirect::to('/admin/category/view-all');
        
    }

    public function editCategory(Request $request, $id){

    	$category = Category::find($id);

    	$sub_categories = Category::where('parent_id', $id)
        ->orderBy('name','ASC')
            ->lists('name','id');

    	return View::make('admin.category.edit-category',['category'=>$category,'subcategories'=>$sub_categories]);
    }

    public function deleteCategory(Request $request, $id){

        $category = Category::find($id);
        $sub_categories = DB::table('categories')
            ->where('parent_id', $id)->pluck('id');
        if(is_array($sub_categories)){

            /* delete using tertiary ID */
            $tCategories = DB::table('categories')->whereIn('parent_id', $sub_categories)->pluck('id');
            DB::table('category_courses')->whereIn('category_id', $tCategories)->delete();

            DB::table('categories')->whereIn('parent_id', $sub_categories)->delete();
            DB::table('categories')->whereIn('id', $sub_categories)->delete();
        }


        $category->delete();

        return Redirect::to('/admin/category/view-all');
    }

    public function updateCategory(Request $request, $id){
        

		$input = $request->all();
        $getCategory = Category::find($id);
        $getCategory ->name = $input['name'];
        $getCategory->save();


        if(isset($input['subcats'])) {
            $subcats = $input['subcats'];

            //dd($input['subcats']);

            CategoryLU::where('category_id', $id)->delete();

            foreach ($subcats as $subcat) {

                $getCategory = new CategoryLU();
                $getCategory->category_id = $id;
                $getCategory->subcategory_id = $subcat;
                $getCategory->save();
            }
        }

        return Redirect::to('/admin/category/edit/'.$id);
    }


    



}
