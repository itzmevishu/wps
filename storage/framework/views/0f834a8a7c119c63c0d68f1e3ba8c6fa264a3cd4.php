<?php $__env->startSection('content'); ?>
<br/><br/><br/><br/>
<!--Display Payment Confirmation-->
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h4>
            <?php echo($customer->name.', Thank you for your Order!');?><br/><br/>
            Shipping Address: </h4>
         Name<br/>
        Address 1<br/>
        Address 2 <br/>
        City<br/>
        500036<br/>
        County<br/>

        <h4>Transaction ID : <?php echo($result->transaction->id);?> <br/>
            State : Approved  <br/>
            Total Amount: <?php echo($result->transaction->amount);?> &nbsp;
            <?php echo($result->transaction->currencyIsoCode); ?> <br/>
        </h4>
        <br/>
        Return to <a href="/">home page</a>.
    </div>
    <div class="col-md-4"></div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>