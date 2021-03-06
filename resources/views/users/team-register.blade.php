@extends('layouts.register')

@section('content')

    <div class="row" id="register-user" style="padding-top:25px;">
        <div class="col-md-12" >
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
            
            <h3>Your Information</h3>
            {{ Form::open(['url' => env('APP_URL').'/team/register/create','id'=>'pivregister']) }}
        </div>
        <div class="col-md-12" >
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('first_name','First Name')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    {{Form::text('first_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>1])}}
                    <div class="errors">{{$errors->first('first_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('last_name','Last Name')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    {{Form::text('last_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>2])}}
                    <div class="errors">{{$errors->first('last_name')}}</div>
                </div>
            </div> 
             <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('username','Username')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    {{Form::text('username',Session::get('username'),['class'=>'form-control','maxlength'=>'255','tabindex'=>3,'placeholder'=>'**Email address is preferred.**'])}}
                    <div class="errors">{{$errors->first('username')}}</div>
                </div>
            </div>            
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('password','Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span>&nbsp;&nbsp;<span class="text-muted small">Password must be 8 characters or longer.</span><br>
                    <input type="password" value="{{old('password')}}" name="password" id="password" class="form-control" maxlength="50" tabindex="4">
                    
                    <div class="errors">
                        {{$errors->first('password')}}
                    </div>
                </div>
            </div>           
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('password_confirmation','Confirm Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    <input type="password" value="{{old('password_confirmation')}}" name="password_confirmation" id="password_confirmation" class="form-control" maxlength="50" tabindex="5">
                    <div class="errors">{{$errors->first('password_confirmation')}}</div>
                </div>
            </div>
                       
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('team_code','Team Code')}}<br>
                    {{Form::text('team_code',NULL,['class'=>'form-control','maxlength'=>'100','tabindex'=>6])}}
                    <div class="errors">{{$errors->first('team_code')}}</div>

                </div>
            </div> 
            
        </div>
        <div class="col-md-12" >
            <div class="row spacer pull-right">                
                {{ Form::submit('Create Account',['class'=>'btn btn-primary btn-lg','tabindex'=>17]) }}
            </div>
            
            {{ Form::close() }}
        </div>
    </div>
    
    <div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Please wait while we create your account.</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

@stop

@section('scripts')
    <script>

        


        $('#pivregister').submit(function() {

            $("#loading").show();
            $("#loading-text").show();
            $("#loading-img").show();

        });

        $(function () {
            $("#password")
                    .popover({ title: 'Password Requirements',html:true, content: "<ul><li>8 characters long</li><li>1 upper case</li><li>1 lower case</li><li>1 number</li><li>1 special character</li></ul>",placement:'top' , trigger: 'hover focus'});
                    //.blur(function () {
                        //$(this).popover('hide');
                   // });
        });

       

    </script>
@stop



