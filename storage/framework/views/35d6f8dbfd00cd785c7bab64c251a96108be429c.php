

<?php $__env->startSection('content'); ?>

    <div class="row" id="register-user" style="padding-top:25px;">
        <div class="col-md-12" >
            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->first('email') == 'The email has already been taken.'): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    This email is already in use. Please try <a href="/password/reset">resetting your password</a>.
                </div>
            <?php endif; ?>
            <h3>Your Information</h3>
            <?php echo e(Form::open(['url' => env('APP_URL').'/create-account','id'=>'pivregister'])); ?>

        </div>
        <div class="col-md-12" >
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('first_name','First Name')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    <?php echo e(Form::text('first_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('first_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('last_name','Last Name')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    <?php echo e(Form::text('last_name','',['class'=>'form-control','maxlength'=>'100','tabindex'=>2])); ?>

                    <div class="errors"><?php echo e($errors->first('last_name')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('email','Email Address')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    <?php echo e(Form::text('email',Session::get('email'),['class'=>'form-control','maxlength'=>'255','tabindex'=>3])); ?>

                    <div class="errors"><?php echo e($errors->first('email')); ?></div>
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('password','Password')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span>&nbsp;&nbsp;<span class="text-muted small">Password must be 8 characters or longer.</span><br>
                    <input type="password" value="<?php echo e(old('password')); ?>" name="password" id="password" class="form-control" maxlength="50" tabindex="5">
                    
                    <div class="errors">
                        <?php echo e($errors->first('password')); ?>

                    </div>
                </div>
            </div>           
           
            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('password_confirmation','Confirm Password')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                    <input type="password" value="<?php echo e(old('password_confirmation')); ?>" name="password_confirmation" id="password_confirmation" class="form-control" maxlength="50" tabindex="6">
                    <div class="errors"><?php echo e($errors->first('password_confirmation')); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-12" >
            <div class="row spacer pull-right">                
                <?php echo e(Form::submit('Create Account',['class'=>'btn btn-primary btn-lg','tabindex'=>17])); ?>

            </div>
            <?php echo e(Form::close()); ?>

        </div>
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
                    .popover({ title: 'Password Requirements',html:true, content: "<ul><li>8 characters long</li><li>1 upper case</li><li>1 lower case</li><li>1 number</li><li>1 special character</li></ul>",placement:'top' , trigger: 'hover focus'});
                    //.blur(function () {
                        //$(this).popover('hide');
                   // });
        });


    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>