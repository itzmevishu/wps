<?php

namespace App\Http\Controllers;

use App\Models\Bogo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Catalog;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

//use Request;
use Auth;
use Crypt;
use Form;
use DB;
use Mail;
use Session;
use View;
use Illuminate\Support\Facades\Input;

class BogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result =

            DB::select(DB::raw("select `catalog`.`name`, `bogos`.`id` , `bogos`.`offer` 
                                from `catalog` 
                                inner join `bogos` on `catalog`.`id` = `bogos`.`course_id` order by `bogos`.`id`"));

        return View::make('bogo.index')
            ->with('bogos', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Catalog::where('active', 1)
            ->where('for_sale', 1)
            ->where('litmos_deleted', 0)
            ->lists('name','id');
        return View::make('bogo.create')
            ->with('courses', $courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'course_id'       => 'required',
            'offer_percentage' => 'required|integer|max:100'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('bogo/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
/*
            $data = $request->all();
            $num_of_courses = $request->input('num_of_courses');
            $offer_percentage = $request->input('offer_percentage');

            if( $num_of_courses == 2 || $num_of_courses == 3){
                $msg =  "1 person gets a % off";
            } elseif($num_of_courses % 2 == 0)
            {
                $msg = ($num_of_courses -2). " person gets a $offer_percentage% off";
            }
            else
            {
                $msg = ($num_of_courses -1). " person gets a $offer_percentage% off";
            }
*/
            $nerd = Bogo::firstOrNew(['course_id' => $request->input('course_id')]);
            $nerd->offer      = $request->input('offer_percentage');
            $nerd->save();

            // redirect
            Session::flash('message', "Offer created Successfully");
            return Redirect::to('bogo/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bogo = Bogo::find($id);
        $bogo->delete();

        // redirect
        Session::flash('message', 'Successfully deleted offer!');
        return Redirect::to('bogo');
    }
}
