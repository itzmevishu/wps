
@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
           <h3>Checkout Preview</h3>
           @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>
    <div class="row well" style="padding-top:10px;margin-left:0px;margin-right:0px;">
            <div class="col-md-12">                
                <h4>Order Summary</h4>
                @foreach ($cart as $cartDetail)
                    <div class="row" style="padding-top:5px;padding-bottom:5px;">
                        <div class="col-md-8" style="">
                            <strong>{{$cartDetail['name']}}</strong>
                        </div>
                        <div class="col-md-4" style="text-align: right">
                            <?php
                            $z_eur_price =($cartDetail['price'] * $currencyRate);
                            $z_eur_price = number_format($z_eur_price, 2, '.', '');
                            ?>

                            @if($cartDetail['price'] <> 0)
                                <div class="usdPrice" style="text-align:right;">&#36;{{$cartDetail['price']}}</div>
                                <div class="altPrice" style="text-align:right;">&euro;{{$z_eur_price}}</div>
                            @endif
                        </div>

                    </div>
                @endforeach
                <div class="row"  style="padding-top:5px;padding-bottom:5px;border-top:1px solid #cccccc">
                    <div class="col-md-8" style="text-align:right;">
                        Subtotal
                    </div>
                    <div class="col-md-4" style="text-align:right;">
                        <?php
                        $z_eur_total =(($cartTotal ) * $currencyRate);
                        $z_eur_total =number_format($z_eur_total, 2, '.', '');

                        ?>
                        <div class="usdPrice" style="text-align:right;">&#36;{{$cartTotal}}</div>
                        <div class="altPrice" style="text-align:right;">&euro;{{$z_eur_total}}</div>
                    </div>

                </div>
                <div class="row"  style="padding-top:5px;padding-bottom:5px;">
                    <div class="col-md-8" style="text-align:right;">
                    Discount
                    </div>

                    <div class="col-md-4" style="text-align:right;">

                        <div class="usdPrice">-&#36;{{$discount}}</div>
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
                        <div class="usdPrice" style="text-align:right;">&#36;{{$z_total}}</div>
                    </div>

                </div>

            </div>
            
    </div>
    <div class="row">
        
        <div class="col-md-12">
            {{ Form::open(['url' => env('APP_URL').'/complete-checkout','id'=>'completeorder']) }}
                <input type="hidden" name="free_checkout" value="yes">                
                <div class="pull-right">{{ Form::submit('Complete Checkout',['class'=>'btn btn-primary btn-lg']) }}</div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Please wait while we process your order.</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

@stop
@section('scripts')
<script>
    $('#completeorder').submit(function() {

        $("#loading").show();
        $("#loading-text").show();
        $("#loading-img").show();

    });

</script>

@stop

