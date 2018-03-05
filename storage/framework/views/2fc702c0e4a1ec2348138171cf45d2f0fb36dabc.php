<?php $__env->startSection('content'); ?>

    <?php $userCount=0; $totalSeats=0;?>

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
    <div class="row" style="padding-top:10px;">
        <div class="col-md-4" >            
            <h3>Your Courses</h3>
            <div class="row cart-hide" style="padding-top:15px;padding-right:15px;">
                    <div class="col-md-7" style="">
                        <strong>Course</strong>
                    </div>
                    <div class="col-md-2 text-center">
                        <strong>Seats</strong>
                    </div>
                    <div class="col-md-3 " style="text-align: right;padding-left:5px;">
                        <strong>Price</strong>
                    </div>
                    
                </div>
            <?php foreach($cart as $cartDetail): ?>
                <div class="row" style="padding-top:15px;padding-right:15px;">
                    <div class="col-md-7" style="">
                        <strong><?php echo e($cartDetail['name']); ?></strong>
                    </div>
                    <div class="col-md-2 price-align">
                        <?php echo e($cartDetail['qty']); ?>

                    </div>
                    <div class="col-md-3 price-align">


                        <?php if($cartDetail['price'] <> 0): ?>
                            <div class="usdPrice">&#36;<?php echo e($cartDetail['price']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                </div>
            <?php endforeach; ?>
            <div class="row"  style="border-top:1px solid #cccccc">
            </div>
            <div class="row spacer" style="padding-right:15px">
                <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Subtotal:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;padding-left:5px;">


                    <div class="usdPrice">&#36;<?php echo e($cartTotal); ?></div>
                </div>

            </div>
            <div class="row spacer" style="padding-right:15px">
                
                 <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Discount:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;">
                   
                    <div class="usdPrice">-&#36;<?php echo e($discount); ?></div>
                </div>

            </div>
            <div class="row spacer" style="padding-right:15px">
                <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Grand Total:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;padding-left:5px;">
                    <?php
                    $z_total =($cartTotal - $discount);
                    $z_total =number_format($z_total, 2, '.', '');
                    ?>

                    <div class="usdPrice">&#36;<?php echo e($z_total); ?></div>
                </div>

            </div>
            
            
        </div>
        <div class="col-md-8" style="border-left:#cccccc 1px solid;">

            <?php foreach($cart as $cartDetails): ?>
                <div class="row spacer" style="padding-top:20px;">
                    <div class="col-md-12">
                    <strong><?php echo e($cartDetails->name); ?></strong><br>
                    <?php echo $cartDetails->options->course_details; ?>

                        </div>
                </div>
            <?php $totalSeats = $totalSeats+$cartDetails['qty'];?>

                <?php foreach($cartDetails->options->assignTo as $key => $assignTo): ?>
                    <div class="row spacer" style="border-bottom:#cccccc 1px solid; padding-bottom: 20px;">

                        <div class="col-md-12"><strong>Seat <?php echo e($key+1); ?></strong></div>

                        <?php if($assignTo['assign'] <> ''): ?>
                            <?php $userCount = $userCount+1;?>

                            <div class="col-md-12">
                                <?php if($assignTo['assign'] == 'self'): ?>
                                    <p>This course will be assigned to:<br>
                                        <?php echo e($userInfo->first_name); ?> <?php echo e($userInfo->last_name); ?> (<?php echo e($userInfo->username); ?>)</p>
                                <?php elseif($assignTo['assign'] == 'existing'): ?>
                                    <p>
                                        This course will be assigned to:<br>
                                        <?php echo e($assignTo['firstname']); ?> <?php echo e($assignTo['lastname']); ?> (<?php echo e($assignTo['litmosusername']); ?>)

                                    </p>
                                <?php elseif($assignTo['assign'] == 'new'): ?>
                                    <p>
                                        This course will be assigned to a new user:<br>
                                        <?php echo e($assignTo['firstname']); ?> <?php echo e($assignTo['lastname']); ?> (<?php echo e($assignTo['litmosusername']); ?>)<br>
                                        Company: <?php echo e($assignTo['company']); ?> <br>
                                        Title: <?php echo e($assignTo['title']); ?><br>
                                        Address: <?php echo e($assignTo['street']); ?> <?php echo e($assignTo['city']); ?>, <?php echo e($assignTo['state']); ?> <?php echo e($assignTo['zip']); ?><br>
                                        Work Phone: <?php echo e($assignTo['workphone']); ?><br>
                                        Country: <?php echo e($assignTo['country']); ?><br>
                                        Timezone: <?php echo e($assignTo['timezone']); ?>


                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php if($key==0): ?>
                                <div class="col-md-3">
                                    <?php echo e(Form::open(['url' => env('APP_URL').'/assign-course'])); ?>

                                    <?php echo e(Form::hidden('rowid',$cartDetails->rowid)); ?>

                                    <?php echo e(Form::hidden('arraycnt',$key)); ?>

                                    <?php echo e(Form::hidden('litmos_id',$userInfo->litmos_id)); ?>

                                    <?php echo e(Form::hidden('first_name',$userInfo->first_name)); ?>

                                    <?php echo e(Form::hidden('last_name',$userInfo->last_name)); ?>

                                    <?php echo e(Form::hidden('email',$userInfo->username)); ?>

                                    <?php echo e(Form::hidden('company',$userInfo->company_name)); ?>

                                    <?php echo e(Form::submit('Assign To Me',['name'=>'assign','class'=>'btn btn-primary btn-lg'])); ?>

                                    <?php echo e(Form::close()); ?>

                                </div>
                            <?php endif; ?>
                            <div class="col-md-3">
                                <?php echo e(Form::open(['url' => env('APP_URL').'/assign-course'])); ?>

                                <?php echo e(Form::hidden('rowid',$cartDetails->rowid)); ?>

                                <?php echo e(Form::hidden('arraycnt',$key)); ?>

                                <?php echo e(Form::hidden('show',0)); ?>

                                <?php echo e(Form::submit('Assign To Other',['name'=>'assign','class'=>'btn btn-primary btn-lg'])); ?>

                                <?php echo e(Form::close()); ?>

                            </div>
                        <?php else: ?>
                            <?php if($key==0): ?>
                                <div class="col-md-3">
                                    <?php echo e(Form::open(['url' => env('APP_URL').'/assign-course'])); ?>

                                    <?php echo e(Form::hidden('rowid',$cartDetails->rowid)); ?>

                                    <?php echo e(Form::hidden('arraycnt',$key)); ?>

                                    <?php echo e(Form::hidden('litmos_id',$userInfo->litmos_id)); ?>

                                    <?php echo e(Form::hidden('first_name',$userInfo->first_name)); ?>

                                    <?php echo e(Form::hidden('last_name',$userInfo->last_name)); ?>

                                    <?php echo e(Form::hidden('email',$userInfo->username)); ?>

                                    <?php echo e(Form::hidden('company',$userInfo->company_name)); ?>

                                    <?php echo e(Form::submit('Assign To Me',['name'=>'assign','class'=>'btn btn-primary btn-lg'])); ?>

                                    <?php echo e(Form::close()); ?>

                                </div>
                            <?php endif; ?>
                            <div class="col-md-3">
                                <?php echo e(Form::open(['url' => env('APP_URL').'/assign-course'])); ?>

                                <?php echo e(Form::hidden('rowid',$cartDetails->rowid)); ?>

                                <?php echo e(Form::hidden('arraycnt',$key)); ?>

                                <?php echo e(Form::hidden('show',0)); ?>

                                <?php echo e(Form::submit('Assign To Other',['name'=>'assign','class'=>'btn btn-primary btn-lg'])); ?>

                                <?php echo e(Form::close()); ?>

                            </div>
                        <?php endif; ?>



                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <div class="spacer col-md-12 text-right">
            <a href="/checkout-step-2" class="btn btn-primary">Continue to Billing</a>
            <a href="/preview-checkout" class="btn btn-primary">Continue to Billing 2</a>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>

    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>