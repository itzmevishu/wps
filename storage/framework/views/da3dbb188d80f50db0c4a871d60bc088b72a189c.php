<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    <div class="col-md-12">

        <a href="/admin"><div> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Return to Admin Home</div></a>

        <?php if(! empty(Session::get('errormsg'))): ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo e(Session::get('errormsg')); ?>

        </div>
        <?php endif; ?>
        <?php if(! empty(Session::get('successMsg'))): ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo e(Session::get('successMsg')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="">
        <div class="row ecomm_pageTitleWrapper">
            <div class="col-md-5" style="">
                <h3 class="ecomm_pageTitle">Admin | All Purchases</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p>Select a date range to download all purchases.</p>
    </div>

    <?php echo e(Form::open(array('url'=>env('APP_URL').'/admin/pull-report','method'=>'POST'))); ?>

    <div class="col-md-6">
        <?php echo e(Form::text('dateRange',NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>3])); ?>

    </div>
    <div class="col-md-6">
        <?php echo e(Form::submit('Get Report',['class'=>'btn btn-primary btn-md col-md-4 text-right','tabindex'=>13])); ?>

    </div>
    <?php echo e(Form::close()); ?>


</div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    $('input[name="dateRange"]').daterangepicker();
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>