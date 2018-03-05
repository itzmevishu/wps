<?php $__env->startSection('content'); ?>

    <div class="row" id="" style="padding-top:25px;">
        <div class="col-md-12" >
            <h3>Your Information</h3>
        </div>
    </div>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <?php if(! empty(Session::get('errorMsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errorMsg')); ?>

                </div>
            <?php endif; ?>
            <?php if(! empty(Session::get('message'))): ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('message')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php echo e(Form::model($user,['url' => env('APP_URL').'/account/update-account'])); ?>

    <div class="row" id="register-user" style="padding-top:25px;">
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('first_name','First Name')); ?><br>
                    <?php echo e(Form::text('first_name',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('first_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                <?php echo e(Form::label('password','Password')); ?> <span class="text-muted small">Password must be at least 8 characters long.</span><br>
                <?php echo e(Form::password('password',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>3])); ?>

                <div class="errors">
                    <?php if(! empty($errors->first('password'))): ?>
                        Password must match and be at least 8 characters long.
                    <?php endif; ?>
                </div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('username','Email Address')); ?><br>
                    <?php echo e(Form::text('username',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>5])); ?>

                    <div class="errors"><?php echo e($errors->first('username')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('title','Title')); ?><br>
                    <?php echo e(Form::text('title',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>7])); ?>

                    <div class="errors"><?php echo e($errors->first('title')); ?></div>
                </div>
            </div>
            <div class="row spacer">

                <div class="col-md-12" style="">
                    <?php echo e(Form::label('country','Country')); ?><br>
                    <?php echo e(Form::select('country',$countries,NULL,['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd','tabindex'=>9])); ?>

                    <div class="errors"><?php echo e($errors->first('country')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('address_line_1','Address')); ?><br>
                    <?php echo e(Form::text('address_line_1',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>11])); ?>

                    <div class="errors"><?php echo e($errors->first('address_line_1')); ?></div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('state','State')); ?><br>
                    <?php echo e(Form::text('state',NULL,['class'=>'form-control','maxlength'=>'100','style'=>'display:none','id'=>'statetext','tabindex'=>13])); ?>

                    <?php echo e(Form::select('state',$states,NULL,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd','tabindex'=>13])); ?>


                    <div class="errors"><?php echo e($errors->first('state')); ?></div>
                </div>
            </div>

        </div>
        <div class="col-md-6" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('last_name','Last Name')); ?><br>
                    <?php echo e(Form::text('last_name',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])); ?>

                    <div class="errors"><?php echo e($errors->first('last_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                <?php echo e(Form::label('password_confirmation','Confirm Password')); ?><br>
                <?php echo e(Form::password('password_confirmation',['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>4])); ?>

                <div class="errors"><?php echo e($errors->first('password_confirmation')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('company_name','Company')); ?><br>
                    <?php echo e(Form::text('company_name',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>6])); ?>

                    <div class="errors"><?php echo e($errors->first('company_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('phone','Work Phone')); ?><br>
                    <?php echo e(Form::text('phone',NULL,['class'=>'form-control','maxlength'=>'50','autocomplete'=>'off','tabindex'=>8])); ?>

                    <div class="errors"><?php echo e($errors->first('phone')); ?></div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('timezone','Timezone')); ?><br>
                    <?php echo e(Form::select('timezone',$timeZones,NULL,['placeholder' => 'Please Select a Timezone','class'=>'form-control','id'=>'id','tabindex'=>10])); ?>


                    <div class="errors"><?php echo e($errors->first('timezone')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                        <?php echo e(Form::label('city','City')); ?><br>
                    <?php echo e(Form::text('city',NULL,['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>12])); ?>

                    <div class="errors"><?php echo e($errors->first('city')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('zip_code','Zip Code')); ?><br>
                    <?php echo e(Form::text('zip_code',NULL,['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>14])); ?>

                    <div class="errors"><?php echo e($errors->first('zip_code')); ?></div>
                </div>
            </div>

        </div>
    </div>
    <div class="row spacer">

            <?php echo e(Form::hidden('id',NULL,[])); ?>

            <?php echo e(Form::hidden('litmos_id',NULL,[])); ?>

            <div class="pull-right">
                <?php echo e(Form::submit('Update',['class'=>'btn btn-primary btn-lg','tabindex'=>16])); ?>

            </div>

    </div>

    <?php echo e(Form::close()); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

                $.get("<?php echo e(url('api/stateDropDown')); ?>",
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
                $.get("<?php echo e(url('api/stateDropDown')); ?>",
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

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>