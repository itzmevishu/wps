<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 1/22/2018
 * Time: 2:57 PM
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 1/22/2018
 * Time: 11:46 AM
 */
?>


<?php $__env->startSection('content'); ?>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
    <h3>Billing Address</h3>
    <?php echo e(Form::open(['url' => env('APP_URL').'/create_cheque_payment', 'id' => "bt-hsf-checkout-form", 'method' => 'post'])); ?>

    <div class="well" style="padding:20px 20px;">
        <div class="spacer row">
            <div class="col-md-6">
                <?php echo e(Form::label('provider_name','Provider Name')); ?><br>
                <?php echo e(Form::text('provider_name',NULL,['class'=>'form-control','maxlength'=>'100'])); ?>

                <div class="errors"><?php echo e($errors->first('provider_name')); ?></div>
            </div>
            <div class="col-md-6">
                <?php echo e(Form::label('npi','National Provider Identifier (NPI)')); ?><br>
                <?php echo e(Form::text('npi',NULL,['class'=>'form-control','maxlength'=>'100'])); ?>

                <div class="errors"><?php echo e($errors->first('npi')); ?></div>
            </div>
        </div>
        <div class="spacer row">
            <div class="col-md-6">
                <?php echo e(Form::label('ptan','Provider Transaction Access Number (PTAN)')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                <?php echo e(Form::text('ptan',NULL,['class'=>'form-control','maxlength'=>'100','id'=>'address_line_1'])); ?>

                <div class="errors"><?php echo e($errors->first('ptan')); ?></div>
            </div>
            <div class="col-md-6">
                <?php echo e(Form::label('address','Address')); ?><br>
                <?php echo e(Form::text('address',NULL,['class'=>'form-control','maxlength'=>'45','id'=>'address'])); ?>

                <div class="errors"><?php echo e($errors->first('address')); ?></div>

            </div>
        </div>
        <div class="spacer row">

        </div>

        <div class="spacer row">
            <div class="col-md-6">
                <?php echo e(Form::label('city','City')); ?>&nbsp;&nbsp;<span class="text-muted small" >(required)</span><br>
                <?php echo e(Form::text('city',NULL,['class'=>'form-control','maxlength'=>'100','id'=>'city'])); ?>

                <div class="errors"><?php echo e($errors->first('city')); ?></div>
            </div>
            <div class="col-md-6">
                <?php echo e(Form::label('state','State')); ?>&nbsp;&nbsp;<span class="text-muted small" id="state_req">(required)</span>
                <?php echo e(Form::select('state',$states,NULL,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd'])); ?>

                <div class="errors"><?php echo e($errors->first('state')); ?></div>
            </div>
        </div>

        <div class="row spacer">


        </div>

        <div class="spacer row">
            <div class="col-md-6">
                <?php echo e(Form::label('country','Country')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                <?php echo e(Form::select('country',$countries,NULL,['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd'])); ?>

                <div class="errors"><?php echo e($errors->first('country')); ?></div>
            </div>
            <div class="col-md-6">
                <?php echo e(Form::label('zip_code','Zip Code',['id'=>'zip_label'])); ?>&nbsp;&nbsp;<span class="text-muted small" id="zip_req">(required)</span>
                <?php echo e(Form::text('zip_code',NULL,['class'=>'form-control','maxlength'=>'10','id'=>'zip_code'])); ?>

                <div class="errors"><?php echo e($errors->first('zip_code')); ?></div>
            </div>
        </div>
        <div class="spacer row">
            <div class="col-md-6">
                <?php echo e(Form::label('phone','Work Phone',['id'=>'phone'])); ?>&nbsp;&nbsp;<span class="text-muted small" id="phone">(required)</span>
                <?php echo e(Form::text('phone',NULL,['class'=>'form-control','maxlength'=>'10','id'=>'zip_code'])); ?>

                <div class="errors"><?php echo e($errors->first('phone')); ?></div>
            </div>
            <div class="col-md-6">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="spacer row">
        <div class="col-md-12 text-right">
            <?php echo e(Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-lg'])); ?>

        </div>
    </div>
    <?php echo e(Form::close()); ?>

    <div class="row">

    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>