@extends('layouts.default')

@section('content')

    <div class="row" id="" style="padding-top:25px;">
        <div class="col-md-12" >
            <h3>Your Information</h3>
        </div>
    </div>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            @if(! empty(Session::get('errorMsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errorMsg')}}
                </div>
            @endif
            @if(! empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
        </div>
    </div>
    {{ Form::model($user,['url' => env('APP_URL').'/account/update-account']) }}
    <div class="row" id="register-user" style="padding-top:25px;">
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('first_name','First Name')}}<br>
                    {{Form::text('first_name',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])}}
                    <div class="errors">{{$errors->first('first_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                {{Form::label('password','Password')}} <span class="text-muted small">Password must be at least 8 characters long.</span><br>
                {{Form::password('password',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>3])}}
                <div class="errors">
                    @if (! empty($errors->first('password')))
                        Password must match and be at least 8 characters long.
                    @endif
                </div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('username','Email Address')}}<br>
                    {{Form::text('username',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>5])}}
                    <div class="errors">{{$errors->first('username')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('title','Title')}}<br>
                    {{Form::text('title',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])}}
                    <div class="errors">{{$errors->first('title')}}</div>
                </div>
            </div>
            <div class="row spacer">

                <div class="col-md-12" style="">
                    {{Form::label('country','Country')}}<br>
                    {{Form::select('country',$countries,NULL,['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd','tabindex'=>9])}}
                    <div class="errors">{{$errors->first('country')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('address_line_1','Address')}}<br>
                    {{Form::text('address_line_1',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>11])}}
                    <div class="errors">{{$errors->first('address_line_1')}}</div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('state','State')}}<br>
                    {{Form::text('state',NULL,['class'=>'form-control','maxlength'=>'100','style'=>'display:none','id'=>'statetext','tabindex'=>13])}}
                    {{Form::select('state',$states,NULL,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd','tabindex'=>13])}}

                    <div class="errors">{{$errors->first('state')}}</div>
                </div>
            </div>

        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('last_name','Last Name')}}<br>
                    {{Form::text('last_name',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])}}
                    <div class="errors">{{$errors->first('last_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                {{Form::label('password_confirmation','Confirm Password')}}<br>
                {{ Form::password('password_confirmation',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>4])}}
                <div class="errors">{{$errors->first('password_confirmation')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('company_name','Company')}}<br>
                    {{Form::text('company_name',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>6])}}
                    <div class="errors">{{$errors->first('company_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('phone','Work Phone')}}<br>
                    {{Form::text('phone',NULL,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>8])}}
                    <div class="errors">{{$errors->first('phone')}}</div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('timezone','Timezone')}}<br>
                    {{Form::select('timezone',$timeZones,NULL,['placeholder' => 'Please Select a Timezone','class'=>'form-control','id'=>'id','tabindex'=>10])}}

                    <div class="errors">{{$errors->first('timezone')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                        {{Form::label('city','City')}}<br>
                    {{Form::text('city',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>12])}}
                    <div class="errors">{{$errors->first('city')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('zip_code','Zip Code')}}<br>
                    {{Form::text('zip_code',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>14])}}
                    <div class="errors">{{$errors->first('zip_code')}}</div>
                </div>
            </div>

        </div>
    </div>
    <div class="row spacer">

            {{Form::hidden('id',NULL,[])}}
            {{Form::hidden('litmos_id',NULL,[])}}
            <div class="pull-right">
                {{ Form::submit('Update',['class'=>'btn btn-primary btn-lg','tabindex'=>16]) }}
            </div>

    </div>

    {{ Form::close() }}


@stop

@section('scripts')
    <script>

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
    </script>

@stop



