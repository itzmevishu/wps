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
use App\Models\CategoryCourse;
use Cache;

class CategoryController extends Controller {

	   

    public function showCategories(Request $request){

    	$getCategories = Category::where('level', 1)->get();
        $courses = \App\Models\Catalog::courses();

    	return View::make('admin.category.show-category',['categories'=>$getCategories, 'courses' => $courses]);
        
    }

    public function addCategory(Request $request){

    	$input = $request->all();

    	$saveCategory = new Category();
        $saveCategory ->name = $input['cat_name'];
        $saveCategory ->level = 1;
        $saveCategory->save();

        if(isset($input['courses']) && count($input['courses']) >= 1){

            foreach($input['courses'] as $course){
                CategoryCourse::firstOrCreate(array('category_id' => $saveCategory->id, 'catalog_id' => $course));
            }
        }
        Cache::forget('categories');
        return Redirect::to('/admin/category/view-all');
        
    }

    public function editCategory(Request $request, $id){

    	$category = Category::find($id);

    	$sub_categories = Category::where('parent_id', $id)
        ->orderBy('name','ASC')
            ->lists('name','id');

        $courses = \App\Models\Catalog::courses();
        $selectedCourses = CategoryCourse::where('category_id', $id)->pluck('catalog_id')->toArray();
        return View::make('admin.category.edit-category',['category'=>$category,'subcategories'=>$sub_categories, 'courses' => $courses, 'selectedCourses' => $selectedCourses]);
    }

    public function deleteCategory(Request $request, $id){

        $category = Category::find($id);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $sub_categories = DB::table('categories')
            ->where('parent_id', $id)->pluck('id');
        if(is_array($sub_categories)){

            /* delete using tertiary ID */
            $tCategories = DB::table('categories')->whereIn('parent_id', $sub_categories)->pluck('id');
            DB::table('category_courses')->whereIn('category_id', $tCategories)->delete();

            DB::table('categories')->whereIn('parent_id', $sub_categories)->delete();
            DB::table('categories')->whereIn('id', $sub_categories)->delete();

        } else {
            DB::table('category_courses')->where('category_id','=' ,$id)->delete();
        }


        $category->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Cache::forget('categories');
        return Redirect::to('/admin/category/view-all');
    }

    public function updateCategory(Request $request, $id){
        

		$input = $request->all();
        $getCategory = Category::find($id);
        $getCategory ->name = $input['name'];
        $getCategory->save();

        if(isset($input['courses']) && count($input['courses']) >= 1){
            CategoryCourse::where('category_id', $id)->delete();
            foreach($input['courses'] as $course){
                CategoryCourse::firstOrCreate(array('category_id' => $id, 'catalog_id' => $course));
            }
        }

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
        Cache::forget('categories');
        return Redirect::to('admin/category/view-all');
    }


    



}
