@extends('layouts.default')

@section('content')
    <div class="row" style="margin-top:75px;">
        <div class="col-md-12">
            @if(! empty(Session::get('message')))
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {!! Session::get('message') !!}
                </div>
            @endif
            @if(! empty(Session::get('status')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {!!Session::get('status')!!}
                </div>
            @endif
            @if(! empty($userMsg))
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {!!$userMsg!!}
                </div>
            @endif
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-stacked col-md-2" style="margin-top: 15px;">
                <li class="active"><a href="#tab_a" data-toggle="pill">Login</a></li>
                <li><a href="#tab_b" data-toggle="pill">Register</a></li>
                <li><a href="#tab_c" data-toggle="pill">Forgot Password</a></li>
            </ul>
            <div class="tab-content col-md-10">
                <div class="tab-pane active" id="tab_a">
                    <div class="row spacer" >
                        <div class="col-md-12 well">
                            <div class="col-md-6">
                                <div class="row spacer" style=" padding:5px;">
                                    <h3 style="margin-top: 0px;">Welcome!</h3>
                                    <p>This is a demo e-commerce store front created by the Litmos Professional Services team.  This template is used as the frame work for custom e-commerce store fronts for Litmos LMS customers that need more than the basic, built-in Litmos LMS store.  This template is the starting point to which Litmos Professional Services will customize to your specific needs.</p>

                                    <p>Have a review, develop your questions, and make an appointment with Litmos PS to discuss your e-commerce goals.</p>


                                </div>
                            </div>
                            <div class="col-md-6" style="border-left:1px solid #cccccc;">
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        <strong style="font-size:large">Already have an account? Login below.</strong>
                                    </div>
                                </div>

                                {{ Form::open(['url' => env('APP_URL').'/sessions']) }}
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('username','Email Address')}}<br>
                                        {{ Form::email('username',NULL,['class'=>'form-control input-lg','tabindex'=>1]) }}
                                        <div class="errors">{{$errors->first('username')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('password','Password')}}<br>
                                        {{Form::password('password',['class'=>'form-control input-lg','tabindex'=>2])}}

                                        <div class="errors">{{$errors->first('password')}}</div>
                                    </div>
                                </div>

                                <div class="row spacer">
                                    <div class="col-md-12">

                                        {{ Form::hidden('course_id',NULL,['class'=>'form-control input-lg']) }}
                                        <div class="pull-right">{{ Form::submit('Login',['class'=>'btn btn-primary btn-lg','style'=>'margin-right:0px;','tabindex'=>3]) }}</div>
                                    </div>
                                </div>
                                {{ Form::close() }}


                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_b">
                    <div class="row spacer" >
                        <div class="col-md-12 well">
                            <div class="col-md-12" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Your Information</h3>
                                        {{ Form::open(['url' => env('APP_URL').'/create-account','id'=>'pivregister']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('first_name','First Name')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('first_name','',['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])}}
                                        <div class="errors">{{$errors->first('first_name')}}</div>
                                    </div>
                                </div>

                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('last_name','Last Name')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('last_name','',['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])}}
                                        <div class="errors">{{$errors->first('last_name')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('email','Email Address')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('email','',['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>3])}}
                                        <div class="errors">{{$errors->first('username')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('password','Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span>&nbsp;&nbsp;<span class="text-muted small">Password must be 8 characters or longer.</span><br>
                                        {{Form::password('password',['name'=>'password','class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>5])}}
                                        <div class="errors">
                                            {{$errors->first('password')}}
                                        </div>
                                    </div>
                                </div>                           
                               
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('password_confirmation','Confirm Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{ Form::password('password_confirmation',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>6])}}
                                        <div class="errors">{{$errors->first('password_confirmation')}}</div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-md-12" >
                                <div class="row spacer">
                                    <div class="pull-right">
                                        {{ Form::submit('Register',['class'=>'btn btn-primary btn-lg','tabindex'=>14]) }}
                                    </div>
                                </div>
                               
                                {{ Form::close() }}
                            </div>

                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="tab_c">
                    <div class="row spacer" >
                        <div class="col-md-12 well">
                            <div class="col-md-6">
                                <div class="row spacer" style=" padding:5px;">
                                    <h3 style="margin-top: 0px;">Password Reset</h3>
                                    <p>Please enter the email address you used to register your account.</p>
                                    <p>An email will be sent to you with a link to reset your password.</p>


                                </div>
                            </div>
                            <div class="col-md-6" style="border-left:1px solid #cccccc;">


                                {{ Form::open(['url' => env('APP_URL').'/password/remind','method'=>'post']) }}

                                {{ Form::email('email',null,['class'=>'form-control input-lg','placeholder'=>'Enter email']) }}



                                <div class="pull-right">
                                    {{ Form::submit('Send Reset Email',['class'=>'btn btn-primary btn-lg','style'=>'margin-right:0px;']) }}
                                </div>


                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- tab content -->
        </div>
    </div>


@stop

@section('scripts')
    
@stop



