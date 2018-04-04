@extends('layouts.default')

@section('content')

    <div class="row" id="register-user" style="padding-top:25px;">
        <div class="col-md-12" >
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
            <h3>Verify Your Information</h3>
            {{ Form::open(['url' => env('APP_URL').'/lms/create-account','id'=>'pivregister']) }}
        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('first_name','First Name')}}: {{$userinfo->FirstName}}
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('last_name','Last Name')}}: {{$userinfo->LastName}}
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('username','Email Address')}}: {{$userinfo->UserName}}
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('company_name','Company')}}: {{$userinfo->CompanyName}}
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('phone','Phone Number')}}: {{$userinfo->PhoneWork}}
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('country','Country')}}: {{$userinfo->Country}}
                </div>
            </div>

        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('password','Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span>&nbsp;&nbsp;<span class="text-muted small">Password must be at least 8 characters long.</span><br>
                    {{Form::password('password',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>7])}}
                    <div class="errors">
                        @if (! empty($errors->first('password')))
                            Password must match and be at least 8 characters long.
                        @endif
                    </div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('password_confirmation','Confirm Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    {{ Form::password('password_confirmation',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>8])}}
                    <div class="errors">{{$errors->first('password_confirmation')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12 text-right">
                    {{ Form::submit('Register',['class'=>'btn btn-primary btn-lg text-right','tabindex'=>12]) }}
                </div>
            </div>
            {{Form::hidden('first_name',$userinfo->FirstName)}}
            {{Form::hidden('last_name',$userinfo->LastName)}}
            {{Form::hidden('company_name',$userinfo->CompanyName)}}
            {{Form::hidden('title',$userinfo->JobTitle)}}
            {{Form::hidden('address_line_1',$userinfo->Street1)}}
            {{Form::hidden('city',$userinfo->City)}}
            {{Form::hidden('state',$userinfo->State)}}
            {{Form::hidden('zip_code',$userinfo->PostalCode)}}
            {{Form::hidden('phone',$userinfo->PhoneWork)}}
            {{Form::hidden('username',$userinfo->UserName)}}
            {{Form::hidden('email',$userinfo->UserName)}}
            {{Form::hidden('country',$userinfo->Country)}}
            {{Form::hidden('timezone',$userinfo->TimeZone)}}
            {{Form::hidden('litmos_id',$userinfo->Id)}}
            {{Form::hidden('litmos_original_id',$userinfo->OriginalId)}}
            {{Form::hidden('courseid',Request::input("courseid"))}}
            {{Form::hidden('verify',$verify)}}
            {{ Form::close() }}
        </div>



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

    </script>
@stop



