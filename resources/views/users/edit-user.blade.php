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
                    {{Form::label('email','Email Address')}}<br>
                    {{Form::text('email',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>5])}}
                    <div class="errors">{{$errors->first('username')}}</div>
                </div>
            </div>
            <!--
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('title','Title')}}<br>
                    {{Form::text('title',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])}}
                    <div class="errors">{{$errors->first('title')}}</div>
                </div>
            </div>
            -->
            <div class="row spacer">

                <div class="col-md-12" style="">
                    {{Form::label('country','Country')}}<br>
                    {{Form::select('country',$countries,NULL,['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd','tabindex'=>9])}}
                    <div class="errors">{{$errors->first('country')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('address','Address')}}<br>
                    {{Form::text('address',$address->address,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>11])}}
                    <div class="errors">{{$errors->first('address')}}</div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('state','State')}}<br>
                    {{Form::text('state',$address->state,['class'=>'form-control','maxlength'=>'100','style'=>'display:none','id'=>'statetext','tabindex'=>13])}}
                    {{Form::select('state',$states,$address->state,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd','tabindex'=>13])}}

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
                    {{Form::label('provider_company','Company')}}<br>
                    {{Form::text('provider_company',$profile->provider_name,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>6])}}
                    <div class="errors">{{$errors->first('company_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('work_phone','Work Phone')}}<br>
                    {{Form::text('work_phone',$profile->phone_number,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>8])}}
                    <div class="errors">{{$errors->first('work_phone')}}</div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('timezone','Timezone')}}<br>
                    {{Form::select('timezone',$timeZones,$profile->timezone,['placeholder' => 'Please Select a Timezone','class'=>'form-control','id'=>'id','tabindex'=>10])}}

                    <div class="errors">{{$errors->first('timezone')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                        {{Form::label('city','City')}}<br>
                    {{Form::text('city',$address->city,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>12])}}
                    <div class="errors">{{$errors->first('city')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {{Form::label('zip_code','Zip Code')}}<br>
                    {{Form::text('zip_code',$address->zip_code,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>14])}}
                    <div class="errors">{{$errors->first('zip_code')}}</div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12">
        <div class="row spacer">
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>

    <div class="col-md-6" >

        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('national_provider_identifier','National Provider Identifier (NPI)')}}&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                {{Form::text('national_provider_identifier',$profile->npi,['class'=>'form-control','maxlength'=>'10','autocomplete'=>'off','tabindex'=>14])}}
                <div class="errors">{{$errors->first('national_provider_identifier')}}</div>
            </div>
        </div>

        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('part_a_or_part_b_provider','Are you a Part A or Part B provider?')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::select('part_a_or_part_b_provider',array('' => 'Please Select an Option')+wpsProviderAB(),$custom_fields[1],['class'=>'form-control','tabindex'=>16])}}
                <div class="errors">{{$errors->first('part_a_or_part_b_provider')}}</div>
            </div>
        </div>
        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('primary_facility_or_provider_type','Primary Facility or Provider Type')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::select('primary_facility_or_provider_type',array('' => 'Please Select an Option')+wpsFacilityProvider() ,$custom_fields[2],['class'=>'form-control','tabindex'=>18])}}
                <div class="errors">{{$errors->first('primary_facility_or_provider_type')}}</div>
            </div>
        </div>
        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('custom_7','Tertiary Facility or Provider Type')}}<br>
                {{Form::select('custom_7',array('' => 'Please Select an Option')+wpsFacilityProvider(), $custom_fields[3], ['class'=>'form-control','tabindex'=>20])}}
            </div>
        </div>
    </div>

    <div class="col-md-6" >
        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('provider_transaction_access_number','Provider Transaction Access Number (PTAN)')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::text('provider_transaction_access_number',$profile->ptan,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>15])}}
                <div class="errors">{{$errors->first('provider_transaction_access_number')}}</div>
            </div>
        </div>
        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('MAC_jurisdiction','Which MAC Jurisdiction are you a part of?')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::select('MAC_jurisdiction',array('' => 'Please Select an Option')+wpsMACJurisdiction(), $custom_fields[4], ['class'=>'form-control','tabindex'=>17])}}
                <div class="errors">{{$errors->first('MAC_jurisdiction')}}</div>
            </div>
        </div>


        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('custom_6','Secondary Facility or Provider Type')}}<br>
                {{Form::select('custom_6',array('' => 'Please Select an Option')+wpsFacilityProvider(), $custom_fields[5],['class'=>'form-control','tabindex'=>19])}}
            </div>
        </div>

        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('custom_8','Physician Specialty Code')}}<br>
                {{Form::select('custom_8',array('' => 'Please Select an Option')+wpsSpecialtyCodes() , $custom_fields[6], ['class'=>'form-control','tabindex'=>21])}}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row spacer">
            <div class="col-md-12">
                {{Form::label('custom_9','Please list any other Facility, Provider Type, or Specialty')}}<br>
                {{Form::text('custom_9',$profile->specialty ,['class'=>'form-control','maxlength'=>'500','autocomplete'=>'off','tabindex'=>23])}}

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



