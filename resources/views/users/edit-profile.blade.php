@extends('layouts.register')
@section('content')

    <div class="row" id="register-user">
        {{ Form::open(['url' => 'account/update_profile']) }}
        @if (isset($user))
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endif
        <div class="col-md-12">
            <div class="row spacer">
                <div class="col-md-12">
                    <h3>Profile Information</h3>
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6" >

            <div class="row spacer">
                <div class="col-md-12">
                    <?php $first_name_default = isset($user) && isset($user->first_name) ? $user->first_name : ''; ?>
                    {{Form::label('first_name','First Name')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::text('first_name', $first_name_default ,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])}}
                    <div class="errors">{{$errors->first('first_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $last_name_default = isset($user) && isset($user->last_name) ? $user->last_name : ''; ?>
                    {{Form::label('last_name','Last Name')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::text('last_name',$last_name_default,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])}}
                    <div class="errors">{{$errors->first('last_name')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $email_default = isset($user) && isset($user->email) ? $user->email : ''; ?>
                    {{Form::label('email_address','Email Address')}}&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;</span><br>
                    {{Form::text('emailaddress',$email_default,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>3, 'disabled' => true])}}
                    {{Form::hidden('email',$email_default)}}
                    {{Form::hidden('email_address',$email_default)}}
                    <div class="errors">{{$errors->first('email_address')}}</div>
                </div>
            </div>

                  <div class="row spacer">
                    <div class="col-md-12">
                        {{Form::label('password','Password')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        {{Form::password('password',['id'=>'password','class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>5])}}
                        <div class="errors">
                            <div class="errors">{{$errors->first('password')}}</div>
                        </div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        {{Form::label('password_confirmation','Confirm Password')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        {{ Form::password('password_confirmation',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>6])}}
                        <div class="errors">{{$errors->first('password_confirmation')}}</div>
                    </div>
                </div>


                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $provider_default = isset($profile) && isset($profile->provider_name) ? $profile->provider_name : ''; ?>
                        {{Form::label('provider_company','Provider/Company Name')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        {{Form::text('provider_company',$provider_default,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>6])}}
                        <div class="errors">{{$errors->first('provider_company')}}</div>
                    </div>
                </div>

        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $address_str = isset($address) && isset($address->address) ? $address->address : ''; ?>
                    {{Form::label('address','Address')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::text('address',$address_str,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])}}
                    <div class="errors">{{$errors->first('address')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $address_city = isset($address) && isset($address->city) ? $address->city : ''; ?>
                    {{Form::label('city','City')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::text('city',$address_city,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>8])}}
                    <div class="errors">{{$errors->first('city')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $address_state = isset($address) && isset($address->state) ? $address->state : NULL; ?>
                    {{Form::label('state','State')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('state', array('' => 'Please Select Your State') +$states, $address_state, ['class'=>'form-control','tabindex'=>9])}}
                    <div class="errors">{{$errors->first('state')}}</div>
                </div>
            </div>

                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $address_zip = isset($address) && isset($address->zip_code) ? $address->zip_code : ''; ?>
                        {{Form::label('zip_code','Zip Code')}}&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        {{Form::text('zip_code',$address_zip,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>10])}}
                        <div class="errors">{{$errors->first('zip_code')}}</div>
                    </div>
                </div>

                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $phone_default = isset($profile) && isset($profile->phone_number) ? $profile->phone_number : ''; ?>
                        {{Form::label('work_phone','Work Phone')}}&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        {{Form::text('work_phone',$phone_default,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>12])}}
                        <div class="errors">{{$errors->first('work_phone')}}</div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $timezone_default = isset($profile) && isset($profile->timezone) ? $profile->timezone : NULL; ?>
                        {{Form::label('timezone','Timezone')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        {{Form::select('timezone',array('' => 'Please Select an Option') +$timeZones,$timezone_default,['class'=>'form-control','tabindex'=>13])}}
                        <div class="errors">{{$errors->first('timezone')}}</div>
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
                    <?php $npi_default = isset($profile) && isset($profile->npi) ? $profile->npi : ''; ?>
                    {{Form::label('national_provider_identifier','National Provider Identifier (NPI)')}}&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                    {{Form::text('national_provider_identifier',$npi_default,['class'=>'form-control','maxlength'=>'10','autocomplete'=>'off','tabindex'=>14])}}
                    <div class="errors">{{$errors->first('national_provider_identifier')}}</div>
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    <?php $part_a_b_provider_default = isset($profile_values) && isset($profile_values['Are you a Part A or Part B provider?']) ? $profile_values['Are you a Part A or Part B provider?'] : NULL; ?>
                    {{Form::label('part_a_or_part_b_provider','Are you a Part A or Part B provider?')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('part_a_or_part_b_provider',array('' => 'Please Select an Option') +$providerAB,$part_a_b_provider_default,['class'=>'form-control','tabindex'=>16])}}
                    <div class="errors">{{$errors->first('part_a_or_part_b_provider')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $primary_provider_type = isset($profile_values) && isset($profile_values['Primary Facility or Provider Type']) ? $profile_values['Primary Facility or Provider Type'] : NULL; ?>
                    {{Form::label('primary_facility_or_provider_type','Primary Facility or Provider Type')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('primary_facility_or_provider_type',array('' => 'Please Select an Option') +$facilityProvider,$primary_provider_type,['class'=>'form-control','tabindex'=>18])}}
                    <div class="errors">{{$errors->first('primary_facility_or_provider_type')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $tertiary_provider_type = isset($profile_values) && isset($profile_values['Tertiary Facility or Provider Type']) ? $profile_values['Tertiary Facility or Provider Type'] : NULL; ?>
                    {{Form::label('custom_7','Tertiary Facility or Provider Type')}}<br>
                    {{Form::select('custom_7',array('' => 'Please Select an Option') +$facilityProvider,$tertiary_provider_type,['class'=>'form-control','tabindex'=>20])}}
                </div>
            </div>
        </div>

        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $ptan_default = isset($profile) && isset($profile->ptan) ? $profile->ptan : ''; ?>
                    {{Form::label('provider_transaction_access_number','Provider Transaction Access Number (PTAN)')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::text('provider_transaction_access_number',$ptan_default,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>15])}}
                    <div class="errors">{{$errors->first('provider_transaction_access_number')}}</div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $mac_jurisdiction = isset($profile_values) && isset($profile_values['Which MAC Jurisdiction are you a part of?']) ? $profile_values['Which MAC Jurisdiction are you a part of?'] : NULL; ?>
                    {{Form::label('MAC_jurisdiction','Which MAC Jurisdiction are you a part of?')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    {{Form::select('MAC_jurisdiction',array('' => 'Please Select an Option') +$macJurisdiction,$mac_jurisdiction,['class'=>'form-control','tabindex'=>17])}}
                    <div class="errors">{{$errors->first('MAC_jurisdiction')}}</div>
                </div>
            </div>


            <div class="row spacer">
                <div class="col-md-12">
                    <?php $secondary_provider_type = isset($profile_values) && isset($profile_values['Secondary Facility or Provider Type']) ? $profile_values['Secondary Facility or Provider Type'] : NULL; ?>
                    {{Form::label('custom_6','Secondary Facility or Provider Type')}}<br>
                    {{Form::select('custom_6',array('' => 'Please Select an Option') +$facilityProvider,$secondary_provider_type,['class'=>'form-control','tabindex'=>19])}}
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    <?php $physician_specialty_code = isset($profile_values) && isset($profile_values['Physician Specialty Code']) ? $profile_values['Physician Specialty Code'] : NULL; ?>
                    {{Form::label('custom_8','Physician Specialty Code')}}<br>
                    {{Form::select('custom_8',array('' => 'Please Select an Option') +$specialtyCodes,$physician_specialty_code,['class'=>'form-control','tabindex'=>21])}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $specialty_default = isset($profile) && isset($profile->specialty) ? $profile->specialty : ''; ?>
                    {{Form::label('custom_9','Please list any other Facility, Provider Type, or Specialty')}}<br>
                    {{Form::text('custom_9',$specialty_default,['class'=>'form-control','maxlength'=>'500','autocomplete'=>'off','tabindex'=>23])}}

                </div>
            </div>
        </div>
        <div class="col-md-12" style="padding-bottom: 25px">
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $submit_text = isset($profile) ? 'Save' : 'Register'; ?>
                    {{ Form::submit($submit_text,['class'=>'btn btn-primary btn-lg col-lg-12 text-right seminar-register-submit','tabindex'=>24]) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
@stop

@section('scripts')
    <script>
        $(function () {
            $("#password")
                .popover({ title: 'Password Requirements',html:true, content: "<ul><li>At least 8 characters long</li><li>1 upper case</li><li>1 lower case</li><li>1 number</li><li>1 special character</li></ul>",placement:'top' , trigger: 'hover focus'});

        });

    </script>
@stop
