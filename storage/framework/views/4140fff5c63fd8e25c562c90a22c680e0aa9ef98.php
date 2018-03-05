<?php $__env->startSection('content'); ?>


    <div class="row" id="register-user">
        <?php echo e(Form::open(['url' => '/create-account', 'id' => 'pivregister'])); ?>

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
                    <?php echo e(Form::label('first_name','First Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('first_name', null ,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('first_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('last_name','Last Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('last_name',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])); ?>

                    <div class="errors"><?php echo e($errors->first('last_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('email_address','Email Address')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(this will be your username)</span><br>
                    <?php echo e(Form::text('email_address',null,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>3])); ?>

                    <div class="errors"><?php echo e($errors->first('email_address')); ?></div>
                </div>
            </div>
            <?php if(!isset($user)): ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('email_address_confirm','Confirm Email Address')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::text('email_address_confirm','',['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>4])); ?>

                        <div class="errors"><?php echo e($errors->first('email_address_confirm')); ?></div>
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
            <?php else: ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('zip_code','Zip Code')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        <?php echo e(Form::text('zip_code',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>5])); ?>

                        <div class="errors"><?php echo e($errors->first('zip_code')); ?></div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('provider_company','Provider/Company Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::text('provider_company',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>6])); ?>

                        <div class="errors"><?php echo e($errors->first('provider_company')); ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('address','Address')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('address',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])); ?>

                    <div class="errors"><?php echo e($errors->first('address')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('city','City')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('city', null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>8])); ?>

                    <div class="errors"><?php echo e($errors->first('city')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('state','State')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('state', wpsStates(),null, ['class'=>'form-control','tabindex'=>9])); ?>

                    <div class="errors"><?php echo e($errors->first('state')); ?></div>
                </div>
            </div>
            <?php if(!isset($user)): ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('zip_code','Zip Code')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        <?php echo e(Form::text('zip_code',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>10])); ?>

                        <div class="errors"><?php echo e($errors->first('zip_code')); ?></div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('provider_company','Provider/Company Name')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::text('provider_company',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>11])); ?>

                        <div class="errors"><?php echo e($errors->first('provider_company')); ?></div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('work_phone','Work Phone')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        <?php echo e(Form::text('work_phone',null,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>12])); ?>

                        <div class="errors"><?php echo e($errors->first('work_phone')); ?></div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('timezone','Timezone')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::select('timezone',array('' => 'Please Select an Option')+wpsTimeZones(), null ,['class'=>'form-control','tabindex'=>13])); ?>

                        <div class="errors"><?php echo e($errors->first('timezone')); ?></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('work_phone','Work Phone')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                        <?php echo e(Form::text('work_phone',null,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>12])); ?>

                        <div class="errors"><?php echo e($errors->first('work_phone')); ?></div>
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::label('timezone','Timezone')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                        <?php echo e(Form::select('timezone',array('' => 'Please Select an Option'), null,['class'=>'form-control','tabindex'=>13])); ?>

                        <div class="errors"><?php echo e($errors->first('timezone')); ?></div>
                    </div>
                </div>
            <?php endif; ?>
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
                    <?php echo e(Form::label('national_provider_identifier','National Provider Identifier (NPI)')); ?>&nbsp;&nbsp;<span class="text-muted small">*&nbsp;&nbsp;(use only numbers)</span><br>
                    <?php echo e(Form::text('national_provider_identifier',null,['class'=>'form-control','maxlength'=>'10','autocomplete'=>'off','tabindex'=>14])); ?>

                    <div class="errors"><?php echo e($errors->first('national_provider_identifier')); ?></div>
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('part_a_or_part_b_provider','Are you a Part A or Part B provider?')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('part_a_or_part_b_provider',array('' => 'Please Select an Option')+wpsProviderAB(),null,['class'=>'form-control','tabindex'=>16])); ?>

                    <div class="errors"><?php echo e($errors->first('part_a_or_part_b_provider')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('primary_facility_or_provider_type','Primary Facility or Provider Type')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('primary_facility_or_provider_type',array('' => 'Please Select an Option')+wpsFacilityProvider() ,null,['class'=>'form-control','tabindex'=>18])); ?>

                    <div class="errors"><?php echo e($errors->first('primary_facility_or_provider_type')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('custom_7','Tertiary Facility or Provider Type')); ?><br>
                    <?php echo e(Form::select('custom_7',array('' => 'Please Select an Option')+wpsFacilityProvider(), null, ['class'=>'form-control','tabindex'=>20])); ?>

                </div>
            </div>
        </div>

        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('provider_transaction_access_number','Provider Transaction Access Number (PTAN)')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::text('provider_transaction_access_number',null,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>15])); ?>

                    <div class="errors"><?php echo e($errors->first('provider_transaction_access_number')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('MAC_jurisdiction','Which MAC Jurisdiction are you a part of?')); ?>&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                    <?php echo e(Form::select('MAC_jurisdiction',array('' => 'Please Select an Option')+wpsMACJurisdiction(), null, ['class'=>'form-control','tabindex'=>17])); ?>

                    <div class="errors"><?php echo e($errors->first('MAC_jurisdiction')); ?></div>
                </div>
            </div>


            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('custom_6','Secondary Facility or Provider Type')); ?><br>
                    <?php echo e(Form::select('custom_6',array('' => 'Please Select an Option')+wpsFacilityProvider(), null,['class'=>'form-control','tabindex'=>19])); ?>

                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('custom_8','Physician Specialty Code')); ?><br>
                    <?php echo e(Form::select('custom_8',array('' => 'Please Select an Option')+wpsSpecialtyCodes() , null, ['class'=>'form-control','tabindex'=>21])); ?>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('custom_9','Please list any other Facility, Provider Type, or Specialty')); ?><br>
                    <?php echo e(Form::text('custom_9',null,['class'=>'form-control','maxlength'=>'500','autocomplete'=>'off','tabindex'=>23])); ?>


                </div>
            </div>
        </div>
        <div class="col-md-12" style="padding-bottom: 25px">
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::submit('Register',['class'=>'btn btn-primary btn-lg col-lg-12 text-right seminar-register-submit','tabindex'=>24])); ?>

                </div>
            </div>
        </div>

        <?php echo e(Form::close()); ?>

    </div>

    <div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Please wait while we create your account.</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>

        $('#pivregister').submit(function() {

            $("#loading").show();
            $("#loading-text").show();
            $("#loading-img").show();

        });
        $(function () {
            $("#password")
                .popover({ title: 'Password Requirements',html:true, content: "<ul><li>At least 8 characters long</li><li>1 upper case</li><li>1 lower case</li><li>1 number</li><li>1 special character</li></ul>",placement:'top' , trigger: 'hover focus'});

        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>