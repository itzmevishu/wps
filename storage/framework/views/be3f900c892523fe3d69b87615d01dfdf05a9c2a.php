<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h3 class="ecomm_pageTitle">Sorry!</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="padding-top:10px;">
        <div class="col-md-12">
            <div class="row spacer">
                <div class="col-md-12">
                    <p>This course is no longer available.</p>
                    <p><a href="store-catalog">Return to Catalog</a></p>
                </div>
            </div>

        </div>


    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>