<?php $__env->startSection('content'); ?>

<div class="container">

<h1>Orders</h1>

<!-- will be used to show any messages -->
<?php if(Session::has('message')): ?>
    <div class="alert alert-info"><?php echo e(Session::get('message')); ?></div>
<?php endif; ?>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>Course ID</td>
        <td>Course Name</td>
        <td>User Email</td>
        <td>Payment ID</td>
        <td>Total Amount</td>
        <td>Status</td>
        <td>Purchase date</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach($orders as $key => $order): ?>
        <tr>
            <td><?php echo e(isset($order->order_details->course_id)?$order->order_details->course_id:'-----'); ?></td>
            <td><?php echo e(isset($order->order_details->course_name)? $order->order_details->course_name:'----'); ?></td>
            <td><?php echo e($order->user->email); ?></td>
            <td><?php echo e($order->payment_id); ?></td>
            <td><?php echo e($order->order_total); ?></td>
            <td><?php echo e($order->success? 'Success':'Fail'); ?></td>
            <td><?php echo e($order->created_at); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>