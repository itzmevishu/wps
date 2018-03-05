<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
           <h3>Checkout Preview</h3>
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
                <h4>Order Summary</h4>
                <?php foreach($cart as $cartDetail): ?>
                    <div class="row" style="padding-top:5px;padding-bottom:5px;">
                        <div class="col-md-8" style="">
                            <strong><?php echo e($cartDetail['name']); ?></strong>
                        </div>
                        <div class="col-md-4" style="text-align: right">
                            <?php
                             if($currencyRate){
                                $z_eur_price =($cartDetail['price'] * $currencyRate);
                             } else {
                                 $z_eur_price =$cartDetail['price'];
                             }

                            $z_eur_price = number_format($z_eur_price, 2, '.', '');
                            ?>

                            <?php if($cartDetail['price'] <> 0): ?>
                                <div class="usdPrice" style="text-align:right;">&#36;<?php echo e($cartDetail['price']); ?></div>
                                <div class="altPrice" style="text-align:right;">&euro;<?php echo e($z_eur_price); ?></div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
                <div class="row"  style="padding-top:5px;padding-bottom:5px;border-top:1px solid #cccccc">
                    <div class="col-md-8" style="text-align:right;">
                        Subtotal
                    </div>
                    <div class="col-md-4" style="text-align:right;">
                        <?php
                            if($currencyRate){
                                $z_eur_total =(($cartTotal ) * $currencyRate);
                            } else{
                                $z_eur_total = $cartTotal;
                            }


                            $z_eur_total =number_format($z_eur_total, 2, '.', '');

                        ?>
                        <div class="usdPrice" style="text-align:right;">&#36;<?php echo e($cartTotal); ?></div>
                        <div class="altPrice" style="text-align:right;">&euro;<?php echo e($z_eur_total); ?></div>
                    </div>

                </div>
                <div class="row"  style="padding-top:5px;padding-bottom:5px;">
                    <div class="col-md-8" style="text-align:right;">
                    Discount
                    </div>

                    <div class="col-md-4" style="text-align:right;">

                        <div class="usdPrice">-&#36;<?php echo e($discount); ?></div>
                    </div>

                </div>
                <div class="row"  style="padding-top:5px;padding-bottom:5px;">
                    <div class="col-md-8" style="text-align:right;">
                    Total
                    </div>
                    <div class="col-md-4" style="text-align:right;">
                        <?php
                    $z_total =($cartTotal - $discount);
                    $z_total =number_format($z_total, 2, '.', '');
                    ?>
                        <div class="usdPrice" style="text-align:right;">&#36;<?php echo e($z_total); ?></div>
                    </div>

                </div>

            </div>
            <div class="row">
        <div class="col-md-6 text-left">
            
        </div>
        <div class="col-md-6 text-right">
            <!--
            <?php echo e(Form::open(['url' =>env('APP_URL').'/complete-checkout','id'=>'stripeCheckout'])); ?>

                <script
                  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                  data-key=<?php echo e(env('STRIPE_PUBLISH_KEY')); ?>

                  data-amount=<?php echo e($cartTotal*100); ?>

                  data-label = 'Pay with Card'
                  data-name="Litmos eComm"
                  data-zip-code="true"
                  data-email = <?php echo e($userAuth['email']); ?>                                                                   
                  data-billing-address="true"
                  data-shipping-address="true"
                  data-description="Litmos Marketplace"
                  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                  data-locale="auto">
                </script>
                <?php echo e(Form::hidden('first_name',$userAuth['first_name'])); ?>

                <?php echo e(Form::hidden('last_name',$userAuth['last_name'])); ?>      
                 
            <?php echo e(Form::close()); ?>

            -->

                <?php echo e(Form::open(['url' =>env('APP_URL').'/complete-checkout','id'=>'bt-hsf-checkout-form'])); ?>

                    <input type="hidden" name="currencyCodeType" value="USD"/>
                    <input type="hidden" id="paymentAmount" name="paymentAmount" value="<?php echo e($z_total); ?>"/>
                    <input type="hidden" name="payment_method_nonce" id ="payment_method_nonce" value="<?php echo e($userResponse['payment_method_nonce']); ?>"/>
                    <input class="btn btn-primary" type="submit" value="Pay"/>

                <?php echo e(Form::close()); ?>

        </div>
    </div>
            
    </div>
    <div class="row">
        
    </div>
    <div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Please wait while we process your order.</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    $('#completeorder').submit(function() {

        $("#loading").show();
        $("#loading-text").show();
        $("#loading-img").show();

    });

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>