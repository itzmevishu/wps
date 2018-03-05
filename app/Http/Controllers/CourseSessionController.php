<?php

namespace App\Http\Controllers;

use App\Models\CourseSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Functions\litmosAPI;

use Form;
use File;
use View;
use Auth;
use App;
use Cart;
use DB;

class CourseSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = "all", $sort = "name_asc")
    {
        $sort_params =  explode('_',$sort);

        if(count($sort_params) == 2){
            $sort_by = $sort_params[0];
            $order_by = $sort_params[1];
        } elseif($sort == 'start_date_asc'){
            $sort_by = 'start_date';
            $order_by = 'asc';
        } elseif($sort == 'start_date_desc'){
            $sort_by = 'start_date';
            $order_by = 'desc';
        }

        $future_sessions = CourseSession::name($search)
                            ->date($search)
                            ->orderBy($sort_by, $order_by)
                            ->paginate(8);

        return View::make('session.index',['sessions'=>$future_sessions, 'searchTerm' =>$search, 'sort' => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }


    public function sync(Request $request){
            $result = CourseSession::saveSessions();
        return Redirect::to('admin/sessions');
    }
}
