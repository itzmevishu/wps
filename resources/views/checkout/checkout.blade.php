@extends('layouts.default')
@section('content')

    <!-- Load the required Braintree client component - Begin -->
    <script src="https://js.braintreegateway.com/web/3.11.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.11.0/js/hosted-fields.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.11.0/js/paypal-checkout.min.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>

    @if (session('payapl_error'))
        <div class="row"  style="padding-top:50px;">
            <div class="col-md-12" style="">
                <div class="alert alert-danger">

                {{dd(session('payapl_error'))}}

                    @if(session('payapl_error'))
                        There was an issue processing your payment. Please try again.
                    @endif

                </div>
            </div>
        </div>
    @endif

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
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
            @foreach ($cart as $cartDetail)
                <div class="row" style="padding-top:15px;padding-right:15px;">
                    <div class="col-md-7 price-align" style="">
                        <strong>{{$cartDetail['name']}}</strong>
                    </div>
                    <div class="col-md-2 price-align">
                        {{$cartDetail['qty']}}
                    </div>
                    <div class="col-md-3 price-align">


                        @if($cartDetail['price'] <> 0)
                            <div class="usdPrice">&#36;{{$cartDetail['price']}}</div>
                        @endif
                    </div>
                    
                </div>
            @endforeach
            <div class="row"  style="border-top:1px solid #cccccc">
            </div>
            <div class="row spacer" style="padding-right:15px">
                <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Subtotal:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;padding-left:5px;">


                    <div class="usdPrice">&#36;{{$cartTotal}}</div>
                </div>

            </div>
            <div class="row spacer" style="padding-right:15px">
                
                 <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Discount:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;">
                   
                    <div class="usdPrice">-&#36;{{$discount}}</div>
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

                    <div class="usdPrice">&#36;{{$z_total}}</div>
                </div>

            </div>
            
            
        </div>
        <div class="col-md-8" style="border-left:#cccccc 1px solid;">

            {{ Form::open(['url' => env('APP_URL').'/preview-checkout', 'id' => "bt-hsf-checkout-form", 'method' => 'post']) }}
            <div><h3>Credit Card Details</h3></div>
            <div id="invalid-field-error" class="btError" style="display:none; color:red;">Please enter the missing credit card fields / enter appropriate values.</div>
            <input type="hidden" name="currencyCodeType" value="USD"/>
            <input type="hidden" id="paymentAmount" name="paymentAmount" value="{{$z_total}}"/>
            <input type="hidden" name="payment_method_nonce" id ="payment_method_nonce"/>

            <div class="well" style="padding:20px 20px;">
                <!--
                <div class="spacer row">
                    <div class="col-md-6">
                        {{Form::label('first_name','First Name')}}<br>
                        {{Form::text('first_name',NULL,['class'=>'form-control','maxlength'=>'100'])}}
                        <div class="errors">{{$errors->first('first_name')}}</div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('last_name','Last Name')}}<br>
                        {{Form::text('last_name',NULL,['class'=>'form-control','maxlength'=>'100'])}}
                        <div class="errors">{{$errors->first('last_name')}}</div>
                    </div>
                </div>
                -->
                <div class="spacer row">
                    <!--
                    <div class="col-md-6">
                        {{Form::label('card_type','Type')}}<br>
                        {{Form::select('card_type', array(
                            'amex' => 'American Express',
                            'discover' => 'Discover',
                            'mastercard' => 'Mastercard',
                            'visa' => 'Visa'),session('billing_info')['card_type'],['class'=>'form-control','placeholder'=>'Choose Card Type'])}}
                        <div class="errors">{{$errors->first('card_type')}}</div>
                    </div>
                    -->
                    <div class="col-md-6">
                        {{Form::label('card-number','Card Number')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        <div class="hosted-field" id="card-number"></div>
                        <div class="errors">{{$errors->first('card_number')}}</div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-4">
                        {{Form::label('expiration-date','Expiration Number')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        <div class="hosted-field" id="expiration-date"></div>
                        <div class="errors">{{$errors->first('exp_month')}}</div>
                    </div>
                    <div class="col-md-4">
                        {{Form::label('cvv','CVV')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        <div class="hosted-field" id="cvv"></div>
                        <div class="errors">{{$errors->first('card_code')}}</div>
                    </div>
                </div>
            </div>
            <h3>Billing Address</h3>
            <div class="well" style="padding:20px 20px;">
                <div class="spacer row">
                    <div class="col-md-12">
                        {{Form::label('address_line_1','Address Line 1')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        {{Form::text('address_line_1',session('billing_info')['address_line_1'],['class'=>'form-control','maxlength'=>'100','id'=>'address_line_1'])}}
                        <div class="errors">{{$errors->first('address_line_1')}}</div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-12">
                        {{Form::label('address_line_2','Address Line 2')}}<br>
                        {{Form::text('address_line_2',session('billing_info')['address_line_2'],['class'=>'form-control','maxlength'=>'45','id'=>'address_line_2'])}}

                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12" style="">
                        {{Form::label('country','Country')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                        {{Form::select('country',$countries,session('billing_info')['country'],['placeholder' => 'Please Select Country','class'=>'form-control','id'=>'countrydd'])}}
                        <div class="errors">{{$errors->first('country')}}</div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-12">
                        {{Form::label('city','City')}}&nbsp;&nbsp;<span class="text-muted small" >(required)</span><br>
                        {{Form::text('city',session('billing_info')['city'],['class'=>'form-control','maxlength'=>'100','id'=>'city'])}}
                        <div class="errors">{{$errors->first('city')}}</div>
                    </div>
                </div>
                <div class="spacer row">
                    <div class="col-md-6">
                        {{Form::label('state','State')}}&nbsp;&nbsp;<span class="text-muted small" id="state_req">(required)</span>
                        {{Form::text('state',session('billing_info')['state'],['class'=>'form-control','maxlength'=>'40','style'=>'display:none','id'=>'statetext'])}}
                        {{Form::select('state',$states,session('billing_info')['state'],['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd'])}}
                        <div class="errors">{{$errors->first('state')}}</div>
                    </div>
                    <div class="col-md-6">
                        {{Form::label('zip_code','Zip Code',['id'=>'zip_label'])}}&nbsp;&nbsp;<span class="text-muted small" id="zip_req">(required)</span>
                        {{Form::text('zip_code',session('billing_info')['zipcode'],['class'=>'form-control','maxlength'=>'10','id'=>'zip_code'])}}
                        <div class="errors">{{$errors->first('zip_code')}}</div>
                    </div>
                </div>
            </div>
            <div class="spacer row">
                <div class="col-md-12 text-right">
                    {{ Form::submit('Preview Checkout',['class'=>'btn btn-primary btn-lg']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <script type="text/javascript">
        var authorization = "<?php print $clientToken; ?>";
        var submit = document.querySelector('input[type="submit"]');
        var btForm = document.getElementById('bt-hsf-checkout-form');
        var btPayPalButton = document.getElementById('bt-paypal-button');
        var paymentAmount = document.getElementById('paymentAmount').value;

        braintree.client.create({
            authorization: authorization
        }, function(clientErr, clientInstance) {
            if (clientErr) { /*Handle error in client creation*/
                console.log('Error creating client instance:: ' + clientErr);
                return;
            }
            /* Braintree - Hosted Fields component */
            braintree.hostedFields.create({
                client: clientInstance,
                styles: {
                    'input': {
                        'font-size': '14pt',
                        'color': '#6E6D6C'
                    },
                    'input.invalid': {
                        'color': 'red'
                    },
                    'input.valid': {
                        'color': 'green'
                    }
                },
                fields: {
                    number: {
                        selector: '#card-number',
                        placeholder: '4111 1111 1111 1111'
                    },
                    cvv: {
                        selector: '#cvv',
                        placeholder: '123'
                    },
                    expirationDate: {
                        selector: '#expiration-date',
                        placeholder: '10/2019'
                    }
                }
            }, function(hostedFieldsErr, hostedFieldsInstance) {
                if (hostedFieldsErr) { /*Handle error in Hosted Fields creation*/
                    return;
                }
                submit.removeAttribute('disabled');
                btForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    hostedFieldsInstance.tokenize(function(tokenizeErr, payload) {
                        if (tokenizeErr) { /* Handle error in Hosted Fields tokenization*/
                            document.getElementById('invalid-field-error').style.display = 'inline';
                            return;
                        } /* Put `payload.nonce` into the `payment-method-nonce` input, and thensubmit the form. Alternatively, you could send the nonce to your serverwith AJAX.*/
                        /* document.querySelector('form#bt-hsf-checkout-form input[name="payment_method_nonce"]').value = payload.nonce;*/
                        document.getElementById('payment_method_nonce').value = payload.nonce;
                        console.log('hostfield nonece', payload.nonce);
                        btForm.method = "get";
                        if ("merchant" === "merchant") {
                            btForm.submit();
                        }
                    });
                }, false);
            });



        });
    </script>
    <!--Styling for the Hosted Fields-->
    <style>
        #card-number, #cvv, #expiration-date {
            -webkit-transition: border-color 160ms;
            transition: border-color 160ms;
            height: 25px;
            width: 250px;
            -moz-appearance: none;
            border: 0 none;
            border-radius: 5px;
            box-shadow: 0 0 4px 1px #a5a5a5 inset;
            color: #DDDBD9;
            display: inline-block;
            float: left;
            font-size: 13px;
            height: 40px;
            margin-right: 2.12766%;
            padding-left: 10px;
        }
    </style>

@stop
@section('scripts')
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

                $.get("{{ url('api/stateDropDown')}}",
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
                $.get("{{ url('api/stateDropDown')}}",
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


@stop

