<?php $__env->startSection('content'); ?>


    <?php if(Session::has('success')): ?>
        <div class="row" style="padding-top:25px;">
            <div class="col-md-12">
                <div class="alert-box success">
                    <h2><?php echo Session::get('success'); ?></h2>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row" style="padding-top:25px;">
        <a href="/admin/promos">Return to Promos</a>
        <div class="col-md-12 well">
            <h3>Promo Details</h3>
            <?php echo Form::open(array('url'=>env('APP_URL').'/admin/promos/add','method'=>'POST')); ?>


            <div class="row spacer">
                <div class="col-md-12">
                    <?php echo e(Form::label('promo_code','Promo Code')); ?><br>
                    <?php echo e(Form::text('promo_code',NULL,['class'=>'form-control','maxlength'=>200,'autocomplete'=>'off','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_code')); ?></div>
                </div>

            </div>

            <h3>Conditions</h3>
            <div class="row spacer">
                <div class="col-md-4" style="">
                    <?php echo e(Form::label('promo_type','Promo Type')); ?><br>
                    <?php echo e(Form::select('promo_type',$getPromoTypes,NULL,['placeholder' => 'Select Promo Type','class'=>'form-control','id'=>'promoType','tabindex'=>9])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_type')); ?></div>
                </div>
                <div class="col-md-4">
                    <?php echo e(Form::label('promo_amount_type','Amount Type')); ?><br>
                    <?php echo e(Form::select('promo_amount_type',['dollar'=>'$ Off','percent'=>'% Off'],NULL,['placeholder' => 'Amount Type','class'=>'form-control','tabindex'=>9,'id'=>'amtType'])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_amount_type')); ?></div>
                </div>

                <div class="col-md-4">
                    <?php echo e(Form::label('promo_apply_to','Apply Promo To')); ?><br>
                    <?php echo e(Form::select('promo_apply_to',['cart'=>'Cart','items'=>'Each Item'],NULL,['placeholder' => 'Apply Promo To','class'=>'form-control','id'=>'applyTo','tabindex'=>9])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_apply_to')); ?></div>
                </div>

            </div>
            <div class="row spacer">
                <div class="col-md-4" id='dollarOff' style="display: none">
                    <?php echo e(Form::label('promo_dollar_off','Promo Dollar Off')); ?><br>
                    <?php echo e(Form::text('promo_dollar_off',NULL,['class'=>'form-control','autocomplete'=>'off','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_dollar_off')); ?></div>
                </div>

                <div class="col-md-4" id='percentOff' style="display: none">
                    <?php echo e(Form::label('promo_percent_off','Promo Percent Off')); ?><br>
                    <?php echo e(Form::text('promo_percent_off',NULL,['class'=>'form-control','autocomplete'=>'off','tabindex'=>1])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_percent_off')); ?></div>
                </div>


            </div>


            <div class="row spacer" id='productDiv' style="display: none;">
                <div class="col-md-12">
                    <h3>Product(s)</h3>
                </div>
                <div class="col-md-12">
                    <?php echo e(Form::select('product_list[]',$courseList,NULL,['placeholder' => 'Choose product(s)','class'=>'form-control','id'=>'productList','tabindex'=>9])); ?>

                    <div class="errors"><?php echo e($errors->first('product_list[]')); ?></div>
                </div>
                <div class="col-md-12 spacer">
                    <?php echo e(Form::checkbox('promo_list_all_req',true,'',['tabindex'=>11])); ?>

                    <?php echo e(Form::label('promo_list_all_req','Require All Products')); ?>

                    <div class="errors"><?php echo e($errors->first('promo_list_all_req')); ?></div>
                </div>
            </div>

            <h3>Date Range</h3>
            <div class="row spacer">
                <div class="col-md-4">
                    <?php echo e(Form::label('promo_start_dt','Promos Start Date')); ?><br>
                    <?php echo e(Form::text('promo_start_dt',NULL,['id'=>'promo_start','class'=>'form-control','autocomplete'=>'off','tabindex'=>1,'id'=>'startDt'])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_start_dt')); ?></div>
                </div>
                <div class="col-md-4">
                    <?php echo e(Form::label('promo_end_dt','Promos End Date')); ?><br>
                    <?php echo e(Form::text('promo_end_dt',NULL,['id'=>'promo_end','class'=>'form-control','autocomplete'=>'off','tabindex'=>1,'id'=>'endDt'])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_end_dt')); ?></div>
                </div>
                <div class="col-md-4">
                    <br>
                    <?php echo e(Form::checkbox('promo_no_expiry','yes','',['tabindex'=>11,'id'=>'noExpire'])); ?>

                    <?php echo e(Form::label('promo_no_expiry','Never Expire')); ?>

                    <div class="errors"><?php echo e($errors->first('promo_no_expiry')); ?></div>
                </div>
            </div>

            <h3>Usage</h3>
            <div class="row spacer">

                <div class="col-md-4">
                    <?php echo e(Form::checkbox('promo_stackable','yes','',['tabindex'=>11])); ?>

                    <?php echo e(Form::label('promo_stackable','Promo Stackable')); ?>

                    <div class="errors"><?php echo e($errors->first('promo_stackable')); ?></div>
                </div>
                <div class="col-md-4">
                    <?php echo e(Form::checkbox('promo_per_customer',true,'',['tabindex'=>11])); ?>

                    <?php echo e(Form::label('promo_per_customer','Single Use Per Customer')); ?>

                    <div class="errors"><?php echo e($errors->first('promo_per_customer')); ?></div>
                </div>
                <div class="col-md-4">
                    <?php echo e(Form::label('promo_qty','Quantity Restriction')); ?>

                    <?php echo e(Form::selectRange('promo_qty', 1, 100,NULL,['class'=>'form-control','placeholder'=>'No Restriction'])); ?>

                    <div class="errors"><?php echo e($errors->first('promo_qty')); ?></div>
                </div>

            </div>

            <div class="row spacer">
                <div class="col-md-4">
                    <?php echo Form::submit('Submit', array('class'=>'btn btn-primary')); ?>

                </div>
            </div>
            <?php echo Form::close(); ?>

            <p class="errors"><?php echo $errors->first('image'); ?></p>
            <?php if(Session::has('error')): ?>
                <p class="errors"><?php echo Session::get('error'); ?></p>
            <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );

        $(function() {
            $( "#startDt" ).datepicker();
            $( "#endDt" ).datepicker();

           

            if($("#promoType").val() == '') {
                $("#applyTo").val("").change();
                $("#amtType").val("").change();
                $('#applyTo').prop("disabled", false);
                $('#productDiv').hide();
                    
            }

            if($("#promoType").val() == 1) {
                $("#applyTo").val("cart").change();
                $('#applyTo').prop("disabled", true);
                $('#productDiv').hide();
            }
            
            if($("#promoType").val() == 2) {
                $('#productDiv').show();
                $('#productList').prop("multiple", "");
            }

            if($("#promoType").val() == 3) {
                $('#productDiv').show();
                $('#productList').prop("multiple", "multiple");
            }
         
            if($("#promoType").val() > 1){               

                if($("#amtType").val() == "dollar") {
                    $('#dollarOff').show();
                    $('#percentOff').hide();

                    //$('#applyTo').prop("disabled", false);
                    //$("#applyTo").val("").change();
                }
                if($("#amtType").val() == "percent") {
                    $('#dollarOff').hide();
                    $('#percentOff').show();

                    $("#applyTo").val("cart").change();
                    $('#applyTo').prop("disabled", true);
                }
                if($("#amtType").val() == "") {
                    $('#dollarOff').hide();
                    $('#percentOff').hide();

                    //$('#applyTo').prop("disabled", false);
                    //$("#applyTo").val("").change();
                }
             }else{
                if($("#amtType").val() == "dollar") {
                    $('#dollarOff').show();
                    $('#percentOff').hide();                        
                }
                if($("#amtType").val() == "percent") {
                    $('#dollarOff').hide();
                    $('#percentOff').show();
                }
                if($("#amtType").val() == "") {
                    $('#dollarOff').hide();
                    $('#percentOff').hide();
                }
             }
            

            if($("#noExpire").is(":checked")) {
                //$('#startDt').prop("disabled", true);
                $('#endDt').prop("disabled", true);
            }else{
                //$('#startDt').prop("disabled", false);
                $('#endDt').prop("disabled", false);
            }

            

            $("#noExpire").change(function(){
                if($(this).is(":checked")) {
                    //$('#startDt').prop("disabled", true);
                    $('#endDt').prop("disabled", true);
                }else{
                    //$('#startDt').prop("disabled", false);
                    $('#endDt').prop("disabled", false);
                }
            });

            $("#amtType").change(function(){

                if($("#promoType").val() > 1){               

                    if($(this).val() == "dollar") {
                        $('#dollarOff').show();
                        $('#percentOff').hide();

                        $('#applyTo').prop("disabled", false);
                        $("#applyTo").val("").change();
                    }
                    if($(this).val() == "percent") {
                        $('#dollarOff').hide();
                        $('#percentOff').show();

                        $("#applyTo").val("cart").change();
                        $('#applyTo').prop("disabled", true);
                    }
                    if($(this).val() == "") {
                        $('#dollarOff').hide();
                        $('#percentOff').hide();

                        $('#applyTo').prop("disabled", false);
                        $("#applyTo").val("").change();
                    }
                 }else{
                    if($(this).val() == "dollar") {
                        $('#dollarOff').show();
                        $('#percentOff').hide();                        
                    }
                    if($(this).val() == "percent") {
                        $('#dollarOff').hide();
                        $('#percentOff').show();
                    }
                    if($(this).val() == "") {
                        $('#dollarOff').hide();
                        $('#percentOff').hide();
                    }
                 }
            });

            $("#promoType").change(function(){

                if($(this).val() == '') {
                    $("#applyTo").val("").change();
                    $("#amtType").val("").change();
                    $('#applyTo').prop("disabled", false);
                    $('#productDiv').hide();
                    
                }

                if($(this).val() == 1) {
                    $("#applyTo").val("cart").change();
                    $('#applyTo').prop("disabled", true);
                    $("#amtType").val("").change();
                    $('#productDiv').hide();
                }

                if($(this).val() == 2) {
                    $("#amtType").val("").change();
                    $('#productDiv').show();
                    $('#productList').prop("multiple", "");
                }

                if($(this).val() == 3) {
                    $("#amtType").val("").change();
                    $('#productDiv').show();
                    $('#productList').prop("multiple", "multiple");
                }

            });

        });
    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>