<?php
namespace App\Http\Controllers;

#use App\CategoryCourse;
use App\Http\Requests;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategoryLU;
use App\Models\SubCategoryLU;
use App\Models\CategoryCourse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use View;
use Form;
use Input;
use Session;



class SubCategoryController extends Controller {

   

    public function showSubCategories($level = 2){

        $categories = Category::where('parent_id')->orderBy('name','ASC')->lists('name','id');

        $sub_categories = Category::where('level', 2)->orderBy('name','ASC')->lists('name','id');

        $courses = \App\Models\Catalog::courses();

        $result =  DB::table('categories')->select('sub_category.id','sub_category.name as subcategory_name','categories.name as category_name')
            ->leftJoin('categories as sub_category','sub_category.parent_id','=','categories.id')
            ->where('sub_category.level', '=', $level)
            ->get();

        return View::make('admin.category.show-subcategory',['sub_categories' => $sub_categories,
            'result' => $result,
            'categories' => $categories,
            'courses' => $courses,
            'level' => $level]);
        
    }

    public function addSubCategory(Request $request){
        
        $input=$request->all();

        $saveCategory = new Category();
        $level = 1;
        if(isset($input['sub_cat_name'])){
            $saveCategory->parent_id = $input['sub_cat_name'];
            $level = 3;
        } else {
            $saveCategory->parent_id = $input['cat_name'];
            $level = 2;
        }
        $saveCategory->level = $level;
        $saveCategory->name = $input['subcat_name'];

        $saveCategory->save();

        if(isset($input['courses']) && count($input['courses']) >= 1){

            foreach($input['courses'] as $course){
                CategoryCourse::firstOrCreate(array('category_id' => $saveCategory->id, 'catalog_id' => $course));
            }
        }

        return Redirect::to('/admin/subcategory/view-all/'.$level);
    }

    public function editSubCategory(Request $request, $id){

        $category  = Category::find($id);
        $parent_id = $category->parent_id;
        $level     = $category->level;
        //parent/root categories
        $categories = Category::where('level',1)->lists('name','id');

        $sub_categories = Category::where('level', 2)->orderBy('name','ASC')->lists('name','id');


        if($level == 3){
            $root_category  = Category::find($parent_id);
            $category_id = $root_category->parent_id;
        } else {
            $category_id = $parent_id;
        }

        $courses = \App\Models\Catalog::courses();

        $getSubCourses = Catalog::where('category_courses.category_id',$id)
            ->select('catalog.id','catalog.name')
            ->join('category_courses','catalog.id','=','catalog_id')
            ->get();

        $savedCourses = [];
        if(count($getSubCourses)>0){
            foreach($getSubCourses as $course){
                array_push($savedCourses, $course->id);
            }

        }else{
             $savedCourses = null;
        }





        return View::make('admin.category.edit-subcategory',[
            'category_id' => $category_id,
            'subcategory'=>$category,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'subparent' => $parent_id,
            'subcatcourses' => $getSubCourses,
            'courses' => $courses,
            'savedCourses' => $savedCourses,
            'level' => $level]);
        
    }

    public function deleteSubCategory(Request $request, $id){

        CategoryCourse::where('category_id',$id)->delete();
        Category::where('id',$id)->delete();
        return Redirect::to('/admin/subcategory/view-all');
    }

    public function updateSubCategory(Request $request, $id){
        

        $input = $request->all();
        $level = $input['level'];

        $getCategory = Category::find($id);
        $getCategory ->name = $input['subcat_name'];
        if($level == 3) {
            $getCategory->parent_id = $input['sub_cat_name'];
        } else {
            $getCategory->parent_id = $input['cat_name'];
        }
        $getCategory->save();
        if(isset($input['courses'])) {
            CategoryCourse::where('category_id', '=', $id)->delete();
            if (count($input['courses']) >= 1) {

                foreach ($input['courses'] as $course) {
                    CategoryCourse::firstOrCreate(array('category_id' => $id, 'catalog_id' => $course));
                    #$category_course ->category_id = $id;
                    #$category_course ->catalog_id = $course;
                    #$category_course->save();
                }
            }
        }
        return Redirect::to('/admin/subcategory/edit/'.$id);
    }

    



}
