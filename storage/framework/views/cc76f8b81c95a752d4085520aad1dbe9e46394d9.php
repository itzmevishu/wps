<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h3 class="ecomm_pageTitle">Account Created</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-top:10px;">
        <div class="col-md-12">
            Your account was successfully created!
            <p>Please check your email for your verification link to finish your registration.</p>


        </div>
    </div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>