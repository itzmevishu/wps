<?php $__env->startSection('content'); ?>

    <div class="row" id="register-user">
        <?php echo e(Form::open(['url' => 'account/update_profile'])); ?>

        <?php if(isset($user)): ?>
            <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
        <?php endif; ?>
        <div class="col-md-12">
            <div class="row spacer">
                <div class="col-md-12">
                    <h3>Profile Information</h3>
                    <?php if($errors->any()): ?>
                        <h4><?php echo e($errors->first()); ?></h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6" >

            <div class="row spacer">
                <div class="col-md-12">
                    <?php $first_name_default = isset($user) && isset($user->first_name) ? $user->first_name : ''; ?>
                    <?php echo e(Form::label('first_name','First Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('first_name', $first_name_default ,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('first_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $last_name_default = isset($user) && isset($user->last_name) ? $user->last_name : ''; ?>
                    <?php echo e(Form::label('last_name','Last Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('last_name',$last_name_default,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])); ?>

                    <div class="errors"><?php echo e($errors->first('last_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $email_default = isset($user) && isset($user->email) ? $user->email : ''; ?>
                    <?php echo e(Form::label('email_address','Email Address')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;</span><br>
                    <?php echo e(Form::text('emailaddress',$email_default,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>3, 'disabled' => true])); ?>

                    <?php echo e(Form::hidden('email',$email_default)); ?>

                    <?php echo e(Form::hidden('email_address',$email_default)); ?>

                    <div class="errors"><?php echo e($errors->first('email_address')); ?></div>
                </div>
            </div>

                  <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('password','Password')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::password('password',['id'=>'password','class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>5])); ?>

                        <div class="errors">
                            <div class="errors"><?php echo e($errors->first('password')); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('password_confirmation','Confirm Password')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::password('password_confirmation',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>6])); ?>

                        <div class="errors"><?php echo e($errors->first('password_confirmation')); ?></div>
                    </div>
                </div>


                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $provider_default = isset($profile) && isset($profile->provider_name) ? $profile->provider_name : ''; ?>
                        <?php echo e(Form::label('provider_company','Provider/Company Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::text('provider_company',$provider_default,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>6])); ?>

                        <div class="errors"><?php echo e($errors->first('provider_company')); ?></div>
                    </div>
                </div>

        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $address_str = isset($address) && isset($address->address) ? $address->address : ''; ?>
                    <?php echo e(Form::label('address','Address')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('address',$address_str,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])); ?>

                    <div class="errors"><?php echo e($errors->first('address')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $address_city = isset($address) && isset($address->city) ? $address->city : ''; ?>
                    <?php echo e(Form::label('city','City')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('city',$address_city,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>8])); ?>

                    <div class="errors"><?php echo e($errors->first('city')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $address_state = isset($address) && isset($address->state) ? $address->state : NULL; ?>
                    <?php echo e(Form::label('state','State')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('state', array('' => 'Please Select Your State') +$states, $address_state, ['class'=>'form-control','tabindex'=>9])); ?>

                    <div class="errors"><?php echo e($errors->first('state')); ?></div>
                </div>
            </div>

                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $address_zip = isset($address) && isset($address->zip_code) ? $address->zip_code : ''; ?>
                        <?php echo e(Form::label('zip_code','Zip Code')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        <?php echo e(Form::text('zip_code',$address_zip,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>10])); ?>

                        <div class="errors"><?php echo e($errors->first('zip_code')); ?></div>
                    </div>
                </div>

                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $phone_default = isset($profile) && isset($profile->phone_number) ? $profile->phone_number : ''; ?>
                        <?php echo e(Form::label('work_phone','Work Phone')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        <?php echo e(Form::text('work_phone',$phone_default,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>12])); ?>

                        <div class="errors"><?php echo e($errors->first('work_phone')); ?></div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php $timezone_default = isset($profile) && isset($profile->timezone) ? $profile->timezone : NULL; ?>
                        <?php echo e(Form::label('timezone','Timezone')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::select('timezone',array('' => 'Please Select an Option') +$timeZones,$timezone_default,['class'=>'form-control','tabindex'=>13])); ?>

                        <div class="errors"><?php echo e($errors->first('timezone')); ?></div>
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
                    <?php echo e(Form::label('national_provider_identifier','National Provider Identifier (NPI)')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                    <?php echo e(Form::text('national_provider_identifier',$npi_default,['class'=>'form-control','maxlength'=>'10','autocomplete'=>'off','tabindex'=>14])); ?>

                    <div class="errors"><?php echo e($errors->first('national_provider_identifier')); ?></div>
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    <?php $part_a_b_provider_default = isset($profile_values) && isset($profile_values['Are you a Part A or Part B provider?']) ? $profile_values['Are you a Part A or Part B provider?'] : NULL; ?>
                    <?php echo e(Form::label('part_a_or_part_b_provider','Are you a Part A or Part B provider?')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('part_a_or_part_b_provider',array('' => 'Please Select an Option') +$providerAB,$part_a_b_provider_default,['class'=>'form-control','tabindex'=>16])); ?>

                    <div class="errors"><?php echo e($errors->first('part_a_or_part_b_provider')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $primary_provider_type = isset($profile_values) && isset($profile_values['Primary Facility or Provider Type']) ? $profile_values['Primary Facility or Provider Type'] : NULL; ?>
                    <?php echo e(Form::label('primary_facility_or_provider_type','Primary Facility or Provider Type')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('primary_facility_or_provider_type',array('' => 'Please Select an Option') +$facilityProvider,$primary_provider_type,['class'=>'form-control','tabindex'=>18])); ?>

                    <div class="errors"><?php echo e($errors->first('primary_facility_or_provider_type')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $tertiary_provider_type = isset($profile_values) && isset($profile_values['Tertiary Facility or Provider Type']) ? $profile_values['Tertiary Facility or Provider Type'] : NULL; ?>
                    <?php echo e(Form::label('custom_7','Tertiary Facility or Provider Type')); ?><br>
                    <?php echo e(Form::select('custom_7',array('' => 'Please Select an Option') +$facilityProvider,$tertiary_provider_type,['class'=>'form-control','tabindex'=>20])); ?>

                </div>
            </div>
        </div>

        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $ptan_default = isset($profile) && isset($profile->ptan) ? $profile->ptan : ''; ?>
                    <?php echo e(Form::label('provider_transaction_access_number','Provider Transaction Access Number (PTAN)')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('provider_transaction_access_number',$ptan_default,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>15])); ?>

                    <div class="errors"><?php echo e($errors->first('provider_transaction_access_number')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $mac_jurisdiction = isset($profile_values) && isset($profile_values['Which MAC Jurisdiction are you a part of?']) ? $profile_values['Which MAC Jurisdiction are you a part of?'] : NULL; ?>
                    <?php echo e(Form::label('MAC_jurisdiction','Which MAC Jurisdiction are you a part of?')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('MAC_jurisdiction',array('' => 'Please Select an Option') +$macJurisdiction,$mac_jurisdiction,['class'=>'form-control','tabindex'=>17])); ?>

                    <div class="errors"><?php echo e($errors->first('MAC_jurisdiction')); ?></div>
                </div>
            </div>


            <div class="row spacer">
                <div class="col-md-12">
                    <?php $secondary_provider_type = isset($profile_values) && isset($profile_values['Secondary Facility or Provider Type']) ? $profile_values['Secondary Facility or Provider Type'] : NULL; ?>
                    <?php echo e(Form::label('custom_6','Secondary Facility or Provider Type')); ?><br>
                    <?php echo e(Form::select('custom_6',array('' => 'Please Select an Option') +$facilityProvider,$secondary_provider_type,['class'=>'form-control','tabindex'=>19])); ?>

                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    <?php $physician_specialty_code = isset($profile_values) && isset($profile_values['Physician Specialty Code']) ? $profile_values['Physician Specialty Code'] : NULL; ?>
                    <?php echo e(Form::label('custom_8','Physician Specialty Code')); ?><br>
                    <?php echo e(Form::select('custom_8',array('' => 'Please Select an Option') +$specialtyCodes,$physician_specialty_code,['class'=>'form-control','tabindex'=>21])); ?>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $specialty_default = isset($profile) && isset($profile->specialty) ? $profile->specialty : ''; ?>
                    <?php echo e(Form::label('custom_9','Please list any other Facility, Provider Type, or Specialty')); ?><br>
                    <?php echo e(Form::text('custom_9',$specialty_default,['class'=>'form-control','maxlength'=>'500','autocomplete'=>'off','tabindex'=>23])); ?>


                </div>
            </div>
        </div>
        <div class="col-md-12" style="padding-bottom: 25px">
            <div class="row spacer">
                <div class="col-md-12">
                    <?php $submit_text = isset($profile) ? 'Save' : 'Register'; ?>
                    <?php echo e(Form::submit($submit_text,['class'=>'btn btn-primary btn-lg col-lg-12 text-right seminar-register-submit','tabindex'=>24])); ?>

                </div>
            </div>
        </div>

        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function () {
            $("#password")
                .popover({ title: 'Password Requirements',html:true, content: "<ul><li>At least 8 characters long</li><li>1 upper case</li><li>1 lower case</li><li>1 number</li><li>1 special character</li></ul>",placement:'top' , trigger: 'hover focus'});

        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.register', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>