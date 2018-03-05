<?php
use App\Models\CourseAssignment;
use App\Models\Orders;
use App\Models\OrderDetails;
?>

<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            
            <h2 class="ecomm_pageTitle">Order Confirmation</h2>
            <p><h4>Thank you for your purchase!</h4></p>
            <p>
            <strong>Assign Courses</strong><br>
            If you haven't already, assign the seat for your course to either yourself or another Altec Sentry learner. You can assign seats now or come back later and assign the seats from your "Orders" page (find it by hovering on your name at the top right of the menu above).</p>
            <p>
            <strong>View Your Courses</strong><br>
            You can view your courses by clicking on the "My Courses" link above. This link will be available anytime you are logged into the Altec Sentry website.
            </p>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="col-md-12 well">
            <div class="row">
                <div class="col-md-6">
                    <strong>Purchase Date:</strong>  <?php echo e(Date('m/d/Y',strtotime($orderInfo['created_at']))); ?>

                </div>
                <div class="col-md-6 pull-right">
                    <strong>Invoice #:</strong>  LITMOS-<?php echo e($orderInfo['id']); ?>

                </div>
            </div>                   
            <div class="row spacer">
                <div class="col-md-12" style="border-bottom:1px solid #cccccc;border-top:1px solid #cccccc;">
                    <strong>Order Details</strong>
                </div>
            </div>
            <div class="row cart-hide">
                <div class="col-md-6">
                    <strong>Course</strong>
                </div>
                <div class="col-md-3">
                    <strong>Seats</strong>
                </div>
                <div class="col-md-3">
                    <strong>Price</strong>
                </div>
            </div>
            <?php foreach($orderDetailInfo as $itemDetail): ?>
                <div class="row spacer">
                    <div class="col-md-6">
                        <?php echo e($itemDetail['course_name']); ?>

                    </div>
                    <div class="col-md-3">
                        <?php echo e($itemDetail['qty']); ?>

                    </div>
                     <?php $courseTotal = ($itemDetail['qty'] * $itemDetail['course_price'])?>
                    <div class="col-md-3">
                        $<?php echo e(money_format('%i',$courseTotal)); ?>

                    </div>
                </div>
            <?php endforeach; ?>
            <?php foreach($promoDetails as $promoDetail): ?>
            <div class="row spacer">
                <div class="col-md-5 price-align"><?php echo e($promoDetail->promo_code); ?> (<?php echo e($promoDetail->promo_desc); ?>)</div>
                <div class="col-md-4 price-align"><strong>Discount</strong></div>
                <div class="col-md-3"> -$<?php echo e(money_format('%i',$promoDetail->promo_amt)); ?></div>
            </div>
            <?php endforeach; ?>
            <div class="row spacer">
                <div class="col-md-9 price-align">
                    <strong>Total</strong>
                </div>
                <div class="col-md-3">
                    $0.00
                </div>
            </div>                       
            <div class="row spacer">
                <div class="col-md-12" style="border-bottom:1px solid #cccccc;border-top:1px solid #cccccc;">
                    <strong>Course Assignments</strong>
                </div>
            </div>
            <div class="row cart-hide">
                <div class="col-md-6">
                    <strong>Course</strong>
                </div>               
                
            </div>
            <?php foreach($assigneeDetails as $detailInfo){ ?>
                <div class="row">
                    <div class="col-md-6">                                     
                        <div class="row spacer">
                            <div class="col-md-12">

                                <?php if($detailInfo['session_name'] == ''): ?>
                                    <?php echo e($detailInfo['course_name']); ?>

                                <?php else: ?>
                                    <?php echo e($detailInfo['session_name']); ?>

                                <?php endif; ?>
                            </div>
                        </div>                                        
                    </div>
                    <?php $getAssignedUsers = CourseAssignment::where('order_detail_id',$detailInfo->id)->get(); ?>
                    <div class="col-md-6">
                        <?php foreach($getAssignedUsers as $key=>$userInfo): ?>

                            <?php if($userInfo['first_name'] == ''): ?>
                                <?php if($key == 0): ?>
                                    <div class="row spacer">
                                        <div class="col-md-4"><span class="seat-count">Seat <?php echo e($key+1); ?></span></div>
                                        <div class="col-md-4">
                                            <a href="/billing/assign-to-me/<?php echo e($userInfo['id']); ?>" class="btn btn-primary">Assign to me</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="/billing/assign-to-form/<?php echo e($userInfo['id']); ?>" class="btn btn-primary">Assign to other</a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="row spacer">
                                        <div class="col-md-4"><span class="seat-count">Seat <?php echo e($key+1); ?></span></div>
                                        <div class="col-md-4">
                                            <a href="/billing/assign-to-form/<?php echo e($userInfo['id']); ?>" class="btn btn-primary">Assign to other</a>
                                        </div>
                                     </div>
                                 <?php endif; ?>                                            
                            <?php else: ?>                                    
                                <div class="row spacer"> 
                                   <div class="col-md-4"><span class="seat-count">Seat <?php echo e($key+1); ?></span></div>
                                    <div class="col-md-8">
                                        <?php echo e($userInfo['first_name']); ?> <?php echo e($userInfo['last_name']); ?> (<?php echo e($userInfo['username']); ?>)
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php } ?>               
        </div>
    </div>        
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
  

</script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>