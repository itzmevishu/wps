@extends('layouts.default')

@section('content')
    <div class="row"  style="padding-top:25px;" id="login-user">
        <div class="col-md-12">
            @if(! empty(Session::get('message')))
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
            @if(! empty(Session::get('status')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{Session::get('status')}}
                </div>
            @endif
        </div>
    </div>
    <div class="row"  style="padding-top:25px;" >
            <div class="col-md-6">
                <div class="row spacer">
                    <p>To shop in the WPS Store, enter your WPS Learning Center email address.</p>
                    <p>You will be asked to verify your account information and a verification email will be sent to you.</p>
                    <p>Don't have an account? {{link_to('/new-account?courseid='.Input::get('courseid'),'Register Now')}}</p>
                </div>
            </div>
            <div class="col-md-6" >

                {{ Form::open(['url' => env('APP_URL').'/get-academy-account']) }}
                <div class="row spacer">
                    <div class="col-md-12">
                        {{Form::label('username','Email Address')}}<br>
                        {{ Form::email('username',NULL,['class'=>'form-control input-lg','tabindex'=>1]) }}
                        <div class="errors">{{$errors->first('username')}}</div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">{{Form::hidden('password','verifyuser',['class'=>'form-control input-lg','tabindex'=>2])}}
                    {{ Form::hidden('course_id',Input::get('courseid'),['class'=>'form-control input-lg','tabindex'=>3]) }}
                    {{ Form::submit('Verify Account',['class'=>'btn btn-primary btn-lg col-lg-12']) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>

    </div>

@stop

@section('scripts')

@stop



