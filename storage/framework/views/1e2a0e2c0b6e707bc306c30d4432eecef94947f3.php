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
    <div class="row well" style="padding-top:10px;margin-left:0px;margin-right:0px;">
        <div class="col-md-12">
            <h4>Chose payment type</h4>
        </div>
        <?php echo e(Form::open(['url' =>env('APP_URL').'/select_payment_option'])); ?>


        <div class="row">
            <div class="col-md-6 text-left">
                <label for="payment_type">Pay By Cheque</label>
                <?php echo e(Form::radio('payment_type', 'cheque')); ?>


            </div>
            <div class="col-md-6 text-left">
                <label for="payment_type">Pay By Card</label>
                <?php echo e(Form::radio('payment_type', 'card')); ?>


            </div>
            <div class="row"><br/></div>
            <?php echo e(Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;"])); ?>

            <?php echo e(Form::close()); ?>

        </div>
    </div>
    <div class="row">

    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>