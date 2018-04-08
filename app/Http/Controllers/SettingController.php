<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests;
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

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = \App\Models\Setting::lists('value', 'key')->toArray();

        return View::make('settings.create')
            ->with(compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $rules = array(
            'editordata'       => 'required',
            'litmos_key'       => 'required',
            'litmos_source'    => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('settings/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store

            $fields = array('welcome' => 'editordata', 'LITMOS_KEY' => 'litmos_key', 'LITMOS_SOURCE' => 'litmos_source', 'google_analytics' => 'google_analytics');
            foreach ($fields as $key => $value){
                $setting = \App\Models\Setting::firstOrNew(['key' => $key]);
                $setting->key = $key;
                $setting->value = trim($request->input($value));
                $setting->save();
            }



            // redirect
            Session::flash('message', 'Application Settings updated.');
            return Redirect::to('settings/create');
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
        return View::make('settings.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return View::make('settings.edit');
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
}
