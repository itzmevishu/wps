
@extends('layouts.default')
@section('content')

    <div class="row" style="padding-top:25px;">
        <h3>Your Orders</h3>

        <div class="col-md-12">
            <div class="row userGridRowHeader">
                <div class="col-md-2 userGridColHeader" >Order Number</div>
                <div class="col-md-3 userGridColHeader" >Order Date</div>
                <div class="col-md-3 userGridColHeader" >Order Total</div>
                <div class="col-md-1 userGridColHeader" >&nbsp;</div>

            </div>

            @foreach ($allOrders as $order)
                <div class="row altBG">
                    <div class="col-md-2 userGridColItem">WPS-{{$order->id}}</div>
                    <div class="col-md-3 userGridColItem">{{date('m-d-Y',strtotime($order->created_at))}}</div>
                    <div class="col-md-3 userGridColItem">${{$order->order_total}}</div>
                    <div class="col-md-2 userGridColItem"><a href="/orders/order-details/{{$order->id}}" class="btn btn-primary">View Details</a></div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-6 text-left" style="padding-left: 0px;">
                    {{ $allOrders->links() }}
                </div>
                <div class="col-md-6 text-right" style="padding-right: 0px; margin: 20px 0px;">


                </div>
            </div>
        </div>
    </div>


@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
@stop

