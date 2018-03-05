

<?php $__env->startSection('content'); ?>
    <?php if(session('payapl_error')): ?>
        <div class="row"  style="padding-top:50px;">
            <div class="col-md-12" style="">
                <div class="alert alert-danger">

                <?php echo e(dd(session('payapl_error'))); ?>


                    <?php if(session('payapl_error')): ?>
                        There was an issue processing your payment. Please try again.
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

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
                    <div class="col-md-7 price-align" style="">
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
            <?php echo e(Form::open(['url' => env('APP_URL').'/preview-checkout'])); ?>

            <div><h3>Credit Card Details</h3></div>
            <div class="well" style="padding:20px 20px;">
                <div class="spacer row">
                    <div class="col-md-6">
                        <?php echo e(Form::label('first_name','First Name')); ?><br>
                        <?php echo e(Form::text('first_name',NULL,['class'=>'form-control','maxlength'=>'100'])); ?>

                        <div class="errors"><?php echo e($errors->first('first_name')); ?></div>
                    </div>
                    <div class="col-md-6">
                        <?php echo e(Form::label('last_name','Last Name')); ?><br>
                        <?php echo e(Form::text('last_name',NULL,['class'=>'form-control','maxlength'=>'100'])); ?>

                        <div class="errors"><?php echo e($errors->first('last_name')); ?></div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-6">
                        <?php echo e(Form::label('card_type','Type')); ?><br>
                        <?php echo e(Form::select('card_type', array(
                            'amex' => 'American Express',
                            'discover' => 'Discover',
                            'mastercard' => 'Mastercard',
                            'visa' => 'Visa'),session('billing_info')['card_type'],['class'=>'form-control','placeholder'=>'Choose Card Type'])); ?>

                        <div class="errors"><?php echo e($errors->first('card_type')); ?></div>
                    </div>
                    <div class="col-md-6">
                        <?php echo e(Form::label('card_number','Card Number')); ?><br>
                        <?php echo e(Form::text('card_number',session('billing_info')['card_number'],['class'=>'form-control','maxlength'=>'19'])); ?>

                        <div class="errors"><?php echo e($errors->first('card_number')); ?></div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-4">
                        <?php echo e(Form::label('exp_month','Expiration Month')); ?><br>
                        <?php echo e(Form::selectRange('exp_month', 1, 12,session('billing_info')['exp_month'],['class'=>'form-control','placeholder'=>'Choose Month'])); ?>

                        <div class="errors"><?php echo e($errors->first('exp_month')); ?></div>
                    </div>
                    <div class="col-md-4">
                        <?php echo e(Form::label('exp_year','Expiration Year')); ?><br>
                        <?php echo e(Form::selectYear('exp_year', date("Y"), date("Y")+10,session('billing_info')['exp_year'],['class'=>'form-control','placeholder'=>'Choose Year'])); ?>

                        <div class="errors"><?php echo e($errors->first('exp_year')); ?></div>
                    </div>
                    <div class="col-md-4">
                        <?php echo e(Form::label('card_code','Security Code')); ?><br>
                        <?php echo e(Form::text('card_code',session('billing_info')['card_code'],['class'=>'form-control','maxlength'=>'10'])); ?>

                        <div class="errors"><?php echo e($errors->first('card_code')); ?></div>
                    </div>
                </div>
            </div>
            <h3>Billing Address</h3>
            <div class="well" style="padding:20px 20px;">
                <div class="spacer row">
                    <div class="col-md-12">
                        <?php echo e(Form::label('address_line_1','Address Line 1')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        <?php echo e(Form::text('address_line_1',session('billing_info')['address_line_1'],['class'=>'form-control','maxlength'=>'100','id'=>'address_line_1'])); ?>

                        <div class="errors"><?php echo e($errors->first('address_line_1')); ?></div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-12">
                        <?php echo e(Form::label('address_line_2','Address Line 2')); ?><br>
                        <?php echo e(Form::text('address_line_2',session('billing_info')['address_line_2'],['class'=>'form-control','maxlength'=>'45','id'=>'address_line_2'])); ?>


                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12" style="">
                        <?php echo e(Form::label('country','Country')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        <?php echo e(Form::select('country',$countries,session('billing_info')['country'],['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd'])); ?>

                        <div class="errors"><?php echo e($errors->first('country')); ?></div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-12">
                        <?php echo e(Form::label('city','City')); ?>&nbsp;&nbsp;<span class="text-muted small" >(required)</span><br>
                        <?php echo e(Form::text('city',session('billing_info')['city'],['class'=>'form-control','maxlength'=>'100','id'=>'city'])); ?>

                        <div class="errors"><?php echo e($errors->first('city')); ?></div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-6">
                        <?php echo e(Form::label('state','State')); ?>&nbsp;&nbsp;<span class="text-muted small" id="state_req">(required)</span>
                        <?php echo e(Form::text('state',session('billing_info')['state'],['class'=>'form-control','maxlength'=>'40','style'=>'display:none','id'=>'statetext'])); ?>

                        <?php echo e(Form::select('state',$states,session('billing_info')['state'],['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd'])); ?>

                        <div class="errors"><?php echo e($errors->first('state')); ?></div>
                    </div>
                    <div class="col-md-6">
                        <?php echo e(Form::label('zip_code','Zip Code',['id'=>'zip_label'])); ?>&nbsp;&nbsp;<span class="text-muted small" id="zip_req">(required)</span>
                        <?php echo e(Form::text('zip_code',session('billing_info')['zipcode'],['class'=>'form-control','maxlength'=>'10','id'=>'zip_code'])); ?>

                        <div class="errors"><?php echo e($errors->first('zip_code')); ?></div>
                    </div>
                </div>
            </div>
            <div class="spacer row">
                <div class="col-md-12 text-right">
                    <?php echo e(Form::submit('Preview Checkout',['class'=>'btn btn-primary btn-lg'])); ?>

                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>

        jQuery(document).ready(function($){

            $("#state_req").hide();
            $("#zip_req").hide();


            if($('#countrydd').val() != ''){

                if($('#countrydd').val() != 'US' && $('#countrydd').val() != 'CA'){
                    $("#state_req").hide();
                    $("#zip_req").hide();
                }else{
                    $("#state_req").show();
                    $("#zip_req").show();
                }

                $.get("<?php echo e(url('api/stateDropDown')); ?>",
                { option: $('#countrydd').val() },
                function(data) {
                    var model = $('#statedd');
                    model.empty();
                    if (data != ''){
                        $("#statedd").show();
                        $("#statetext").hide();
                        model.append("<option value=''>Choose State</option>");
                        $.each(data, function(index, element) {
                            if($("#statetext").val() == element.name){
                                model.append("<option value='"+ element.name +"' selected>" + element.name + "</option>");
                            }else{
                                model.append("<option value='"+ element.name +"'>" + element.name + "</option>");
                            }
                        });
                    }else{
                        $("#statedd").hide();
                        $("#statetext").show();
                    }
                });
            }

            $('#countrydd').change(function(){
                $('#statedd').empty();
                $("#statedd").hide();
                $("#statetext").hide();
                $.get("<?php echo e(url('api/stateDropDown')); ?>",
                { option: $(this).val() },
                function(data) {
                    var model = $('#statedd');
                    model.empty();
                    if (data != ''){
                        $("#statedd").show();
                        model.append("<option value=''>Choose State</option>");
                        $.each(data, function(index, element) {
                            if($("#statetext").val() == element.name){
                                model.append("<option value='"+ element.name +"' selected>" + element.name + "</option>");
                            }else{
                                model.append("<option value='"+ element.name +"'>" + element.name + "</option>");
                            }
                        });
                    }else{
                        $("#statetext").show();
                    }
                });
                if($('#countrydd').val() != 'US' && $('#countrydd').val() != 'CA'){
                    $("#state_req").hide();
                    $("#zip_req").hide();
                }else{
                    $("#state_req").show();
                    $("#zip_req").show();
                }
            });
        });

    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>