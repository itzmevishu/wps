@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h3 class="ecomm_pageTitle">Your Cart</h3>
                </div>
            </div>
        </div>
    </div>
    @if ($cartCount > 0)
        <div class="row" style="padding-top:10px;">
            <div class="col-md-12">
                @if(! empty(Session::get('errormsg')))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{Session::get('errormsg')}}
                    </div>
                @endif
                    @if(! empty(Session::get('message')))
                        <div class="alert alert-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{Session::get('message')}}
                        </div>
                    @endif
                <div class="row cart-hide" style="padding-top:15px;">
                        <div class="col-md-5" style="">
                            <strong>Course Name</strong>
                        </div>
                        <div class="col-md-2 " style="text-align: right">
                            <strong>Price</strong>
                        </div>
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
                @foreach ($cart as $cartDetail)
                    <div class="row" style="padding-top:15px;">
                        <div class="col-md-5" style="">
                            {{$cartDetail['name']}}<br>{{$cartDetail['options']['location']}}

                        </div>

                        <div class="col-md-2 price-align">
                           <div class="usdPrice">&#36;{{$cartDetail['price']}}</div>
                        </div>
                        <div class="col-md-2 price-align">
                            {{ Form::open(['url' =>env('APP_URL').'/update-cart','name'=>'qtyUpdate_'.$cartDetail['rowid']]) }}
                                {{Form::selectRange('qty', 1, $cartDetail['options']['seats_available'],$cartDetail['qty'],['id'=>'qty','class'=>'form-control','style'=>'width:65px;display: inline','onchange'=>'this.form.submit();'])}}
                            <input type="hidden" name="rowid" style="width:50px;display: inline;" class="form-control " value="{{$cartDetail['rowid']}}">
                            {{Form::close()}}

                        </div>
                        <div class="col-md-2 cart-hide" style="text-align: right">
                            <?php
                            $total_price =$cartDetail['subtotal'];
                            $total_price = number_format($total_price, 2, '.', '');
                            ?>
                                &#36;{{$total_price}}
                        </div>
                        <div class="col-md-1 cart-icon-btn">
                            <a href="{{env('APP_URL')}}/remove-course?rowid={{$cartDetail['rowid']}}" class="" style="color: #6c6c6c;padding: 1px 5px;"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                        <div class="col-md-1 cart-button-btn">
                            <button class="btn btn-secondary" href="{{env('APP_URL')}}/remove-course?rowid={{$cartDetail['rowid']}}" style="margin-top: 15px;">Remove</button>
                        </div>

                    </div>
                @endforeach
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

                            @if($cartTotal <> 0)
                                <div class="usdPrice">&#36;{{$cartTotal}}</div>
                                <div class="altPrice">&euro;{{$z_eur_total}}</div>
                            @else
                                FREE
                            @endif
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
                        @if(count($discount)>0)
                        <?php

                        $discountTotal =number_format($discountTotal, 2, '.', '');
                        ?>
                        <div class="usdPrice">-&#36;{{$discountTotal}}</div>
                        @endif
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
                       BOGO Discount:
                    </div>
                    <div class="col-md-2" style="text-align: right">
                        ${{$bogoDiscount}}
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
                        $cartTotal =($cartTotal - $discountTotal - $bogoDiscount);
                        $cartTotal =number_format($cartTotal, 2, '.', '');
                        ?>
                        <strong>

                            <div class="usdPrice">&#36;{{$cartTotal}}</div>
                            </strong>
                    </div>
                    <div class="col-md-1 " style="text-align: right">
                    </div>

                </div>
            </div>
        </div>
        <div class="row" style="padding-top:45px;">

            @if(count($discount)>0)
                <div class="col-md-12" style="text-align: left">
                    <strong>Discount(s)</strong><br>
                    @foreach ($discount as $discountDetail)
                        <div style="padding:5px;">{{$discountDetail['name']}} ({{$discountDetail['options']['description']}})&nbsp;&nbsp;<a href="{{env('APP_URL')}}/remove-discount?rowid={{$discountDetail['rowid']}}"  style="color: #6c6c6c;padding: 1px 5px;"><span class="glyphicon glyphicon-remove"></span></a></div>

                    @endforeach
                </div>

            @endif
        </div>


                @if(count($promos))
                    <div class="row spacer">
                    {{ Form::open(['url' =>env('APP_URL').'/add-discount']) }}
                    <div class="col-md-4 price-align">

                        {{Form::text('discount_code','',['class'=>'form-control col-md-4','autocomplete'=>'off','tabindex'=>1,'placeholder'=>'Discount Code'])}}

                    </div>
                    <div class="col-md-3 discount-btn-align">
                        {{ Form::submit('Apply Code',['class'=>'btn btn-primary','style'=>"margin-right:0px;"]) }}

                    </div>
                    {{ Form::close() }}
                    </div>
                    <div class="row spacer">
                    <div class="col-md-12 button-align">
                        {{ Form::open(['url' =>env('APP_URL').'/checkout-step-1']) }}
                        {{ Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;"]) }}
                        {{ Form::close() }}
                    </div>
                    </div>
                @else
                    <div class="row spacer">
                    <div class="col-md-12 text-right">
                        <!--
                        {{ Form::open(['url' =>env('APP_URL').'/checkout-step-1']) }}
                        {{ Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;"]) }}
                        {{ Form::close() }}
                        -->
                        {!! Html::link('/payment_type', 'Begin Checkout', array('class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;")) !!}
                    </div>
                    </div>

                @endif







    @else
        <div class="row" style="padding-top:10px;">
            <div class="col-md-12">

               No items in your cart!
            </div>
        </div>
    @endif

@stop
@section('scripts')



@stop

