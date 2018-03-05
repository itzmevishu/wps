

<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h3 class="ecomm_pageTitle">Your Cart</h3>
                </div>
            </div>
        </div>
    </div>
    <?php if($cartCount > 0): ?>
        <div class="row" style="padding-top:10px;">
            <div class="col-md-12">
                <?php if(! empty(Session::get('errormsg'))): ?>
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo e(Session::get('errormsg')); ?>

                    </div>
                <?php endif; ?>
                    <?php if(! empty(Session::get('message'))): ?>
                        <div class="alert alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo e(Session::get('message')); ?>

                        </div>
                    <?php endif; ?>
                <div class="row cart-hide" style="padding-top:15px;">
                        <div class="col-md-5" style="">
                            <strong>Course Name</strong>
                        </div>
                        <div class="col-md-2 " style="text-align: right">
                            <strong>Price</strong>
                        </div>
                        <div class="col-md-2 " style="text-align: right">
                            <strong>Seats</strong>
                        </div>
                        <div class="col-md-2 " style="text-align: right">
                            <strong>Total</strong>
                        </div>
                        <div class="col-md-1 " style="text-align: right">
                        </div>

                    </div>
                <?php foreach($cart as $cartDetail): ?>
                    <div class="row" style="padding-top:15px;">
                        <div class="col-md-5" style="">
                            <?php echo e($cartDetail['name']); ?><br><?php echo e($cartDetail['options']['location']); ?>


                        </div>

                        <div class="col-md-2 price-align">
                           <div class="usdPrice">&#36;<?php echo e($cartDetail['price']); ?></div>
                        </div>
                        <div class="col-md-2 price-align">
                            <?php echo e(Form::open(['url' =>env('APP_URL').'/update-cart','name'=>'qtyUpdate_'.$cartDetail['rowid']])); ?>

                                <?php echo e(Form::selectRange('qty', 1, $cartDetail['options']['seats_available'],$cartDetail['qty'],['id'=>'qty','class'=>'form-control','style'=>'width:65px;display: inline','onchange'=>'this.form.submit();'])); ?>

                            <input type="hidden" name="rowid" style="width:50px;display: inline;" class="form-control " value="<?php echo e($cartDetail['rowid']); ?>">
                            <?php echo e(Form::close()); ?>


                        </div>
                        <div class="col-md-2 cart-hide" style="text-align: right">
                            <?php
                            $total_price =$cartDetail['subtotal'];
                            $total_price = number_format($total_price, 2, '.', '');
                            ?>
                                &#36;<?php echo e($total_price); ?>

                        </div>
                        <div class="col-md-1 cart-icon-btn">
                            <a href="<?php echo e(env('APP_URL')); ?>/remove-course?rowid=<?php echo e($cartDetail['rowid']); ?>" class="" style="color: #6c6c6c;padding: 1px 5px;"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        <div class="col-md-1 cart-button-btn">
                            <button class="btn btn-secondary" href="<?php echo e(env('APP_URL')); ?>/remove-course?rowid=<?php echo e($cartDetail['rowid']); ?>" style="margin-top: 15px;">Remove</button>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row" style="padding-top:25px;">
            <div class="col-md-12">
                <div class="row" style="padding-top:15px;border-top: #cccccc 1px solid;">
                    <div class="col-md-9" style="text-align: right;">
                        Subtotal:
                    </div>
                    <div class="col-md-2" style="text-align: right">
                        <?php
                        $z_eur_total =($cartTotal * 0);
                        $z_eur_total =number_format($z_eur_total, 2, '.', '');
                        ?>

                            <?php if($cartTotal <> 0): ?>
                                <div class="usdPrice">&#36;<?php echo e($cartTotal); ?></div>
                                <div class="altPrice">&euro;<?php echo e($z_eur_total); ?></div>
                            <?php else: ?>
                                FREE
                            <?php endif; ?>
                    </div>
                    <div class="col-md-1 " style="text-align: right">
                        </div>

                </div>
            </div>
        </div>
        <div class="row" style="padding-top:5px;">
            <div class="col-md-12">
                <div class="row" style="">
                    <div class="col-md-9" style="text-align: right;">
                        Discount:
                    </div>
                    <div class="col-md-2" style="text-align: right">
                        <?php if(count($discount)>0): ?>
                        <?php

                        $discountTotal =number_format($discountTotal, 2, '.', '');
                        ?>
                        <div class="usdPrice">-&#36;<?php echo e($discountTotal); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-1 " style="text-align: right">
                        </div>

                </div>
            </div>
        </div>
        <div class="row" style="padding-top:25px;">
            <div class="col-md-12">
                <div class="row" style="padding-top:15px;border-top: #cccccc 1px solid;">
                    <div class="col-md-9" style="text-align: right;">
                        <strong>Total</strong>
                    </div>
                    <div class="col-md-2" style="text-align: right">
                        <?php
                        $cartTotal =($cartTotal - $discountTotal);
                        $cartTotal =number_format($cartTotal, 2, '.', '');
                        ?>
                        <strong>

                            <div class="usdPrice">&#36;<?php echo e($cartTotal); ?></div>
                            </strong>
                    </div>
                    <div class="col-md-1 " style="text-align: right">
                    </div>

                </div>
            </div>
        </div>
        <div class="row" style="padding-top:45px;">

            <?php if(count($discount)>0): ?>
                <div class="col-md-12" style="text-align: left">
                    <strong>Discount(s)</strong><br>
                    <?php foreach($discount as $discountDetail): ?>
                        <div style="padding:5px;"><?php echo e($discountDetail['name']); ?> (<?php echo e($discountDetail['options']['description']); ?>)&nbsp;&nbsp;<a href="<?php echo e(env('APP_URL')); ?>/remove-discount?rowid=<?php echo e($discountDetail['rowid']); ?>"  style="color: #6c6c6c;padding: 1px 5px;"><span class="glyphicon glyphicon-remove"></span></a></div>

                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>


                <?php if(count($promos)): ?>
                    <div class="row spacer">
                    <?php echo e(Form::open(['url' =>env('APP_URL').'/add-discount'])); ?>

                    <div class="col-md-4 price-align">

                        <?php echo e(Form::text('discount_code','',['class'=>'form-control col-md-4','autocomplete'=>'off','tabindex'=>1,'placeholder'=>'Discount Code'])); ?>


                    </div>
                    <div class="col-md-3 discount-btn-align">
                        <?php echo e(Form::submit('Apply Code',['class'=>'btn btn-primary','style'=>"margin-right:0px;"])); ?>


                    </div>
                    <?php echo e(Form::close()); ?>

                    </div>
                    <div class="row spacer">
                    <div class="col-md-12 button-align">
                        <?php echo e(Form::open(['url' =>env('APP_URL').'/checkout-step-1'])); ?>

                        <?php echo e(Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;"])); ?>

                        <?php echo e(Form::close()); ?>

                    </div>
                    </div>
                <?php else: ?>
                    <div class="row spacer">
                    <div class="col-md-12 text-right">
                        <?php echo e(Form::open(['url' =>env('APP_URL').'/checkout-step-1'])); ?>

                        <?php echo e(Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;"])); ?>

                        <?php echo e(Form::close()); ?>

                    </div>
                    </div>

                <?php endif; ?>







    <?php else: ?>
        <div class="row" style="padding-top:10px;">
            <div class="col-md-12">

               No items in your cart!
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>