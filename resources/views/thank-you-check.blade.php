<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 4/5/2018
 * Time: 6:34 PM
 */
?>
<?php
use App\Models\CourseAssignment;
use App\Models\Orders;
use App\Models\OrderDetails;
?>
@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">

            <h2 class="ecomm_pageTitle">Order Confirmation</h2>
            <p><h4>Thank you for your order!</h4></p>

            <p>
                <strong>View Your Courses</strong><br>
                You can view your courses by clicking on the "My Courses" link above. This link will be available anytime you are logged into the WPS Learning Center.
            </p>
            <p>
                {!! Html::link('/downloadPDF/'.$orderInfo['id'], 'Download Order', array('class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;")) !!}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 well">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Order Date:</strong>  {{Date('m/d/Y',strtotime($orderInfo['created_at']))}}
                    </div>
                    <div class="col-md-6 pull-right">
                        <strong>Invoice #:</strong>  LITMOS-{{$orderInfo['id']}}
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12" style="border-bottom:1px solid #cccccc;border-top:1px solid #cccccc;">
                        <strong>Order Details</strong>
                    </div>
                </div>
                <div class="row cart-hide">
                    <div class="col-md-6">
                        <strong>Course</strong>
                    </div>
                    <div class="col-md-3">
                        <strong>Seats</strong>
                    </div>
                    <div class="col-md-3">
                        <strong>Price</strong>
                    </div>
                </div>
                @foreach($orderDetailInfo as $itemDetail)
                    <div class="row spacer">
                        <div class="col-md-6">
                            {{$itemDetail['course_name']}}
                        </div>
                        <div class="col-md-3">
                            {{$itemDetail['qty']}}
                        </div>
                        <?php $courseTotal = ($itemDetail['qty'] * $itemDetail['course_price'])?>
                        <div class="col-md-3">
                            ${{number_format($courseTotal, 2)}}
                        </div>
                    </div>
                @endforeach
                @foreach($promoDetails as $promoDetail)
                    <div class="row spacer">
                        <div class="col-md-5 price-align">{{$promoDetail->promo_code}} ({{$promoDetail->promo_desc}})</div>
                        <div class="col-md-4 price-align"><strong>Discount</strong></div>
                        <div class="col-md-3"> -${{number_format($promoDetail->promo_amt, 2)}}</div>
                    </div>
                @endforeach
                <div class="row spacer">
                    <div class="col-md-9 price-align">
                        <strong>Total</strong>
                    </div>
                    <div class="col-md-3">
                        ${{number_format($orderInfo['order_total'], 2)}}
                    </div>
                </div>
                <div class="row spacer">
                    <div class="col-md-12" style="border-bottom:1px solid #cccccc;border-top:1px solid #cccccc;">
                        <strong>Course Assignments</strong>
                    </div>
                </div>
                <div class="row cart-hide">
                    <div class="col-md-6">
                        <strong>Course</strong>
                    </div>

                </div>
                <?php foreach($assigneeDetails as $detailInfo){ ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row spacer">
                            <div class="col-md-12">

                                @if($detailInfo['session_name'] == '')
                                    {{$detailInfo['course_name']}}
                                @else
                                    {{$detailInfo['session_name']}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <?php $getAssignedUsers = CourseAssignment::where('order_detail_id',$detailInfo->id)->get(); ?>

                    <div class="col-md-6">
                        @foreach($getAssignedUsers as $key=>$userInfo)

                            @if($userInfo['first_name'] == '')
                                @if($key == 0)
                                    <div class="row spacer">
                                        <div class="col-md-4"><span class="seat-count">Seat {{$key+1}}</span></div>
                                        <div class="col-md-4">
                                            <a href="/billing/assign-to-me/{{$userInfo['id']}}" class="btn btn-primary">Assign to me</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="/billing/assign-to-form/{{$userInfo['id']}}" class="btn btn-primary">Assign to other</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="row spacer">
                                        <div class="col-md-4"><span class="seat-count">Seat {{$key+1}}</span></div>
                                        <div class="col-md-4">
                                            <a href="/billing/assign-to-form/{{$userInfo['id']}}" class="btn btn-primary">Assign to other</a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="row spacer">
                                    <div class="col-md-4"><span class="seat-count">Seat {{$key+1}}</span></div>
                                    <div class="col-md-8">
                                        {{$userInfo['first_name']}} {{$userInfo['last_name']}} ({{$userInfo['username']}})
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>


@stop
@section('scripts')
@stop

