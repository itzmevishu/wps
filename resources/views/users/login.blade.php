@extends('layouts.default')

@section('content')
    <div class="row" style="margin-top:75px;">
        <div class="col-md-12">
            @if(! empty(Session::get('message')))
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {!!Session::get('message')!!}
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
                <li><a href="/password/reset">Forgot Password</a></li>
            </ul>
            <div class="tab-content col-md-10">
                <div class="tab-pane active" id="tab_a">
                    <div class="row spacer" >
                        <div class="col-md-12 well">
                            <div class="col-md-6">
                                <div class="row spacer" style=" padding:5px;">
                                    <h3 style="margin-top: 0px;">Welcome!</h3>
                                    <p>Welcome to the WPS Learning Center!</p>


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
                                        {{ Form::email('username',NULL,['class'=>'form-control','tabindex'=>1]) }}
                                        <div class="errors">{{$errors->first('username')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('password','Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span>&nbsp;&nbsp;<span class="text-muted small">Password must be 8 characters or longer.</span><br>
                                        {{Form::password('password',['id'=>'password','class'=>'form-control','maxlength'=>'50','tabindex'=>2])}}
                                        <div class="errors">
                                            {{$errors->first('password')}}
                                        </div>
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
                            <div class="col-md-6" >
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('first_name','First Name')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('first_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>1])}}
                                        <div class="errors">{{$errors->first('first_name')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('username','Email Address')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('username',Session::get('email'),['class'=>'form-control','maxlength'=>'255','tabindex'=>3])}}
                                        <div class="errors">{{$errors->first('username')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('password','Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span>&nbsp;&nbsp;<span class="text-muted small">Password must be 8 characters or longer.</span><br>
                                        <input type="password" value="{{old('password')}}" name="password" id="password" class="form-control" maxlength="50" tabindex="5">
                                        <div class="errors">
                                            {{$errors->first('password')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('title','Title')}}<br>
                                        {{Form::text('title','',['class'=>'form-control','maxlength'=>'100','tabindex'=>7])}}
                                        <div class="errors">{{$errors->first('title')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">

                                    <div class="col-md-12" style="">
                                        {{Form::label('country','Country')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::select('country',$countries,NULL,['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd','tabindex'=>9])}}
                                        <div class="errors">{{$errors->first('country')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('address_line_1','Address')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{ Form::text('address_line_1',NULL,['class'=>'form-control','maxlength'=>'100','tabindex'=>11])}}
                                        <div class="errors">{{$errors->first('address_line_1')}}</div>
                                    </div>

                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('state','State')}}&nbsp;&nbsp;<span class="text-muted small" id="state_req">(required)</span><br>
                                        {{Form::text('state',NULL,['class'=>'form-control','maxlength'=>'100','style'=>'display:none','id'=>'statetext','tabindex'=>13])}}
                                        {{Form::select('state',$states,NULL,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd','tabindex'=>13])}}

                                        <div class="errors">{{$errors->first('state')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('serial_number','Serial Number')}}<br>
                                        {{Form::text('serial_number',NULL,['class'=>'form-control','id'=>'serial_number','maxlength'=>'100','tabindex'=>15])}}
                                        <div class="errors">{{Session::get('serialNumberMsg')}}</div><div class="errors">{{$errors->first('serial_number')}}</div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6" >
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('last_name','Last Name')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('last_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>2])}}
                                        <div class="errors">{{$errors->first('last_name')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('company_name','Company')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('company_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>4])}}
                                        <div class="errors">{{$errors->first('company_name')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('password_confirmation','Confirm Password')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        <input type="password" value="{{old('password_confirmation')}}" name="password_confirmation" id="password_confirmation" class="form-control" maxlength="50" tabindex="6">
                                        <div class="errors">{{$errors->first('password_confirmation')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('phone','Work Phone')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('phone','',['class'=>'form-control','maxlength'=>'50','tabindex'=>8])}}
                                        <div class="errors">{{$errors->first('phone')}}</div>
                                    </div>

                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('timezone','Timezone')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::select('timezone',$timeZones,NULL,['placeholder' => 'Please Select a Timezone','class'=>'form-control','id'=>'id','tabindex'=>10])}}

                                        <div class="errors">{{$errors->first('timezone')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('city','City')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                                        {{Form::text('city','',['class'=>'form-control','maxlength'=>'255','tabindex'=>12])}}
                                        <div class="errors">{{$errors->first('city')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('zip_code','Zip Code')}}&nbsp;&nbsp;<span class="text-muted small" id="zip_req">(required)</span><br>
                                        {{Form::text('zip_code','',['class'=>'form-control','maxlength'=>'100','tabindex'=>14])}}
                                        <div class="errors">{{$errors->first('zip_code')}}</div>
                                    </div>
                                </div>
                                <div class="row spacer">
                                    <div class="col-md-12">
                                        {{Form::label('activation_code','Activation Code')}}<br>
                                        {{Form::text('activation_code',NULL,['class'=>'form-control','maxlength'=>'100','tabindex'=>16])}}
                                        <div class="errors">{{$errors->first('activation_code')}}</div><div class="errors">{{$errors->first('actCodeMsg')}}</div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12" >
                                <div class="row spacer">
                                    <div class="pull-right">
                                        {{ Form::submit('Register',['class'=>'btn btn-primary btn-lg','tabindex'=>14]) }}
                                    </div>
                                </div>
                                {{Form::hidden('courseid',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off'])}}
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
                                
                                    
                                        {{ Form::open(['url' => env('APP_URL').'/password/reset','method'=>'post']) }}

                                {{ csrf_field() }}
                                        
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
<script>
    

    $(function(){
            $('#phone').keyup(function()
            {
                this.value = this.value.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3');
                //alert ("OK");
            });
        });

        jQuery(document).ready(function($){

            $("#state_req").hide();
            $("#zip_req").hide();


            if($('#countrydd').val() != ''){

                if($('#countrydd').val() != 'United States' && $('#countrydd').val() != 'Canada'){
                    $("#state_req").hide();
                    $("#zip_req").hide();
                }else{
                    $("#state_req").show();
                    $("#zip_req").show();
                }

                $.get("{{ url('api/stateDropDown')}}",
                        { option: $('#countrydd').val() },
                        function(data) {
                            var model = $('#statedd');
                            model.empty();
                            if (data != ''){
                                $("#statedd").show();
                                $("#statetext").hide();
                                model.append("<option value=''>Choose State</option>");
                                $.each(data, function(index, element) {
                                    if($("#statetext").val() == element.name){
                                        model.append("<option value='"+ element.name +"' selected>" + element.name + "</option>");
                                    }else{
                                        model.append("<option value='"+ element.name +"'>" + element.name + "</option>");
                                    }
                                });
                            }else{
                                $("#statedd").hide();
                                $("#statetext").show();
                            }
                        });
            }

            $('#countrydd').change(function(){
                $('#statedd').empty();
                $("#statedd").hide();
                $("#statetext").hide();
                $.get("{{ url('api/stateDropDown')}}",
                        { option: $(this).val() },
                        function(data) {
                            var model = $('#statedd');
                            model.empty();
                            if (data != ''){
                                $("#statedd").show();
                                model.append("<option value=''>Choose State</option>");
                                $.each(data, function(index, element) {
                                    model.append("<option value='"+ element.name +"'>" + element.name + "</option>");
                                });
                            }else{
                                $("#statetext").show();
                            }
                        });
                if($('#countrydd').val() != 'United States' && $('#countrydd').val() != 'Canada'){
                    $("#state_req").hide();
                    $("#zip_req").hide();
                }else{
                    $("#state_req").show();
                    $("#zip_req").show();
                }
            });
        });

    $('#pivregister').submit(function() {

        $("#loading").show();
        $("#loading-text").show();
        $("#loading-img").show();

    });

    $(function () {
        $("#password_new")
                .popover({ title: 'Password Requirements',html:true, content: "<ul><li>8 characters long</li><li>1 upper case</li><li>1 lower case</li><li>1 number</li><li>1 special character</li></ul>",placement:'top' , trigger: 'hover focus'});
                //.blur(function () {
                    //$(this).popover('hide');
               // });
    });

    $(function () {
        $("#serial_number").popover({ title: 'Serial Number Location',html:true, content: "<img src='/images/altec_serial.jpg'>",placement:'top' , trigger: 'hover focus'});
    });

    $(function () {
        $("#activation_code").popover({ title: 'Activation Code Location',html:true, content: "<img src='/images/altec_activation.png'>",placement:'top' , trigger: 'hover focus'});
    });
</script>
@stop



