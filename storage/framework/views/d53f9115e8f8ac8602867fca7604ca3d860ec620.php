<?php $__env->startSection('content'); ?>

    <div class="row" style="padding-top:25px;">
        <h3>Your Orders</h3>

        <div class="col-md-12">
            <div class="row userGridRowHeader">
                <div class="col-md-2 userGridColHeader" >Order Number</div>
                <div class="col-md-3 userGridColHeader" >Order Date</div>
                <div class="col-md-3 userGridColHeader" >Order Total</div>
                <div class="col-md-1 userGridColHeader" >&nbsp;</div>

            </div>

            <?php foreach($allOrders as $order): ?>
                <div class="row altBG">
                    <div class="col-md-2 userGridColItem">LITMOS-<?php echo e($order->id); ?></div>
                    <div class="col-md-3 userGridColItem"><?php echo e(date('m-d-Y',strtotime($order->created_at))); ?></div>
                    <div class="col-md-3 userGridColItem">$<?php echo e(money_format('%i',$order->order_total)); ?></div>
                    <div class="col-md-2 userGridColItem"><a href="/orders/order-details/<?php echo e($order->id); ?>" class="btn btn-primary">View Details</a></div>
                </div>
            <?php endforeach; ?>
            <div class="row">
                <div class="col-md-6 text-left" style="padding-left: 0px;">
                    <?php echo e($allOrders->links()); ?>

                </div>
                <div class="col-md-6 text-right" style="padding-right: 0px; margin: 20px 0px;">


                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>