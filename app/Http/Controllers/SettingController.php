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
        $welcomeMessage = \App\Models\Setting::where('key', 'welcome')->pluck('value')->first();

        return View::make('settings.create', [ 'welcomeMessage' => $welcomeMessage]);
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
            'editordata'       => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('settings/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store

            $data = $request->all();


            $nerd = \App\Models\Setting::firstOrNew(['key' => 'welcome']);
            $nerd->key = 'welcome';
            $nerd->value = $request->input('editordata');
            $nerd->save();

            // redirect
            Session::flash('message', 'Welcome message updated.');
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
