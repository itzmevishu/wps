
@extends('layouts.default')
@section('content')

    <?php $userCount=0; $totalSeats=0;?>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
         @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h2 class="ecomm_pageTitle">Assign WPS Learning Learner</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12">
            <p>Please use the form to search for a WPS Learning Learner. If no user is found, you will have the ability to create the user.</p>
            <h4>Course Name</h4>
            <span style="font-size:medium"> 
                @if($course['session_name'] == '')
                    {{$course['course_name']}}
                @else
                   {{$course['session_name']}}
                @endif
            </span><br><br>
        </div>
    </div>    
    <div class="row well" id="searchform">
        <div class="col-md-12">
            <strong>Find WPS Learning Learner</strong><br>
            Check if the user you want to assign already has an WPS Learning learning account.
        </div>
        <div class="col-md-4" style="padding-top: 10px">

            {{Form::text('email',NULL,['placeholder'=>'Search by Email (sample@domain.com)','class'=>'form-control','id'=>'email'])}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="errors" id="emailError"></div>

        </div>
        <div class="col-md-6" style="padding-top: 10px">
            <button class="btn btn-primary btn-lg" id="searchName">Search</button>

        </div>
        <div class="col-md-12" style="padding-top:5px;">
            <p><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;Search requires a full email address.</p>
        </div>
    </div>

    <div class="row well spacer" style="display:none;" id="foundUser">
        <div class="col-md-12">
            <strong>Is this the correct WPS Learning Learner?</strong><br>
            <div style="margin-top:10px;"><span id="firstname"></span> <span id="lastname"></span> (<span id="username"></span>)</div>
            {{ Form::open(['url' => env('APP_URL').'/billing/assign-to-existing/'.$seatid]) }}
            {{Form::hidden('litmosid',NULL,['id'=>'litmosid'])}}
            {{Form::hidden('firstname',NULL,['id'=>'FirstName'])}}
            {{Form::hidden('lastname',NULL,['id'=>'LastName'])}}
            {{Form::hidden('username',NULL,['id'=>'UserName'])}}
            {{Form::hidden('company_name',NULL,['id'=>'CompanyName'])}}
            {{ Form::submit('Yes! Assign to Course',['class'=>'btn btn-primary','style'=>'margin-top:10px','tabindex'=>11]) }}
            <button class="btn btn-primary" style="margin-top:10px;" id="searchAgain">Return to Search</button>
            {{ Form::close() }}

        </div>

    </div>

    @if(app('request')->input('sec')=='new')
        <div class=" row well" style="padding-top:20px;display:" id="newuser">
    @else
        <div class=" row well" style="padding-top:20px;display:none" id="newuser">
    @endif
        <div class="row">
            <div class="col-md-12">
            <strong>Create a New WPS Learning Learner</strong><br>
            The user you searched for was not found. Please fill out the form to create an account.
            </div>
        </div>
        {{ Form::open(['url' => env('APP_URL').'/billing/assign-to-new/'.$seatid]) }}
        <div class="row spacer">
            <div class="col-md-6">
                {{Form::label('first_name','First Name')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::text('first_name','',['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])}}
                <div class="errors">{{$errors->first('first_name')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('last_name','Last Name')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::text('last_name','',['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])}}
                <div class="errors">{{$errors->first('last_name')}}</div>
            </div>
        </div>
        <div class="row spacer">
            <div class="col-md-6">
                {{Form::label('email','Email Address')}}<span class="text-muted small">*</span><br>
                {{Form::text('email',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>3])}}
                <div class="errors">{{$errors->first('email')}}</div>
            </div>
            <div class="row spacer">
                <div class="col-md-6">
                    {{Form::label('address','Address')}}<span class="text-muted small">*</span><br>
                    {{Form::text('address',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>4])}}
                    <div class="errors">{{$errors->first('address')}}</div>
                </div>

            </div>
        </div>
        <div class="row spacer">
            <div class="col-md-6">
                {{Form::label('city','City')}}<span class="text-muted small">*</span><br>
                {{Form::text('city',null,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>5])}}
                <div class="errors">{{$errors->first('city')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('state','State')}}<span class="text-muted small">*</span><br>
                {{Form::text('state',null,['class'=>'form-control','maxlength'=>'100','style'=>'display:none','id'=>'statetext','tabindex'=>6])}}
                {{Form::select('state',$states,null,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd','tabindex'=>6])}}
                <div class="errors">{{$errors->first('state')}}</div>
            </div>
        </div>
        <div class="row spacer">
            <div class="col-md-6">
                {{Form::label('zip_code','Zip Code')}}<span class="text-muted small">*</span><br>
                {{Form::text('zip_code',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])}}
                <div class="errors">{{$errors->first('zip_code')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('timezone','Timezone')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::select('timezone',$timeZones,NULL,['placeholder' => 'Please Select a Timezone','class'=>'form-control','id'=>'id','tabindex'=>8])}}

                <div class="errors">{{$errors->first('timezone')}}</div>
            </div>

        </div>
        <div class="row spacer">

            <div class="col-md-6">
                {{Form::label('provider_company','Company')}}<br>
                {{Form::text('provider_company',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>9])}}
                <div class="errors">{{$errors->first('company_name')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('work_phone','Work Phone')}}<br>
                {{Form::text('work_phone',isset($profile->phone_number)?$profile->phone_number:'',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>10])}}
                <div class="errors">{{$errors->first('work_phone')}}</div>
            </div>
        </div>

            <div class="row spacer">

                <div class="col-md-12">
                    <hr/>
                </div>
            </div>


        <div class="row spacer">
            <div class="col-md-6">
                {{Form::label('national_provider_identifier','National Provider Identifier (NPI)')}}&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                {{Form::text('national_provider_identifier',null,['class'=>'form-control','maxlength'=>'10','autocomplete'=>'off','tabindex'=>11])}}
                <div class="errors">{{$errors->first('national_provider_identifier')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('provider_transaction_access_number','Provider Transaction Access Number (PTAN)')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                {{Form::text('provider_transaction_access_number',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>12])}}
                <div class="errors">{{$errors->first('provider_transaction_access_number')}}</div>
            </div>
        </div>

            <div class="row spacer">
                <div class="col-md-6">
                    {{Form::label('part_a_or_part_b_provider','Are you a Part A or Part B provider?')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('part_a_or_part_b_provider',array('' => 'Please Select an Option')+wpsProviderAB(),null,['class'=>'form-control','tabindex'=>13])}}
                    <div class="errors">{{$errors->first('part_a_or_part_b_provider')}}</div>
                </div>
                <div class="col-md-6">
                    {{Form::label('MAC_jurisdiction','Which MAC Jurisdiction are you a part of?')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('MAC_jurisdiction',array('' => 'Please Select an Option')+wpsMACJurisdiction(), null, ['class'=>'form-control','tabindex'=>14])}}
                    <div class="errors">{{$errors->first('MAC_jurisdiction')}}</div>
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-6">
                    {{Form::label('primary_facility_or_provider_type','Primary Facility or Provider Type')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('primary_facility_or_provider_type',array('' => 'Please Select an Option')+wpsFacilityProvider() ,null,['class'=>'form-control','tabindex'=>15])}}
                    <div class="errors">{{$errors->first('primary_facility_or_provider_type')}}</div>
                </div>
                <div class="col-md-6">
                    {{Form::label('custom_6','Secondary Facility or Provider Type')}}<br>
                    {{Form::select('custom_6',array('' => 'Please Select an Option')+wpsFacilityProvider(), null,['class'=>'form-control','tabindex'=>16])}}
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-6">
                    {{Form::label('custom_7','Tertiary Facility or Provider Type')}}<br>
                    {{Form::select('custom_7',array('' => 'Please Select an Option')+wpsFacilityProvider(), null, ['class'=>'form-control','tabindex'=>17])}}
                </div>
                <div class="col-md-6">
                    {{Form::label('custom_8','Physician Specialty Code')}}<br>
                    {{Form::select('custom_8',array('' => 'Please Select an Option')+wpsSpecialtyCodes() , null, ['class'=>'form-control','tabindex'=>18])}}
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-6">
                    {{Form::label('custom_9','Please list any other Facility, Provider Type, or Specialty')}}<br>
                    {{Form::text('custom_9',null ,['class'=>'form-control','maxlength'=>'500','autocomplete'=>'off','tabindex'=>19])}}
                </div>
                <div class="col-md-6">
                    &nbsp;
                </div>
            </div>

        <div class="row spacer">
            <div class="col-md-12 text-right">
                {{Form::hidden('assign','Assign To Other')}}
                {{ Form::submit('Create New User',['class'=>'btn btn-primary','tabindex'=>20]) }}
            </div>
        </div>
        {{ Form::close() }}

        </div>

    </div>



@stop
@section('scripts')

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function validEmail(v) {
    var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (v.match(r) == null) ? false : true;
    }
    jQuery(document).ready(function($){
        
        $('#searchAgain').click(function(){
            $('#searchform').show();
            $('#foundUser').hide();
            $('#email').val('');
            $('#emailError').text('');

            return false;
        });


        $('#searchName').click(function(){

            if($('#email').val() != '' && validEmail($('#email').val())){
                var userEmail, token, url, data;
                token = $('input[name=_token]').val();
                userEmail = $('#email').val();
                url = '/check-email';
                data = {userEmail: userEmail};
                $.ajax({
                    url: url,
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    type: 'POST',
                    datatype: 'JSON',
                    success: function (resp) {

                        if(resp == 500 || resp == 404){
                            $('#newuser').show();
                            $('#foundUser').hide();
                            $('#username_2').val($('#email').val());
                        }else{
                            console.log(resp);
                            respJson = jQuery.parseJSON(resp);
                            //respJson = respJson[0];
                            $('#foundUser').show();
                            $('#searchform').hide();
                            $('#newuser').hide();
                            $('#litmosid').val(respJson.Id);
                            $('#FirstName').val(respJson.FirstName);
                            $('#LastName').val(respJson.LastName);
                            $('#UserName').val(respJson.UserName);
                            $('#username').html(respJson.UserName);
                            $('#CompanyName').val(respJson.CompanyName);

                        }
                    }
                });
            }else{
                //alert('hello');
                $('#emailError').text('Email Address is required.')
            }
        });
    });

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
</script>

@stop


