<?php
use App\Models\CourseAssignment;
use App\Models\Orders;
use App\Models\OrderDetails;
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Altec Sentry Purchase Summary</h2>

<table>
    <tr>
        <td style="padding: 5px"><strong>Purchase Date:</strong>  {{Date('m/d/Y',strtotime($orderInfo['created_at']))}}</td>
        <td style="padding: 5px"><strong>Invoice #:</strong>  LITMOS-{{$orderInfo['id']}}</td>
    </tr>
    
    <tr>
        <td style="padding: 5px"><strong>Order Details</strong></td>
    </tr>
    <tr>
        <td style="padding: 5px"><strong>Course</strong></td>
        <td style="padding: 5px"><strong>Seats</strong></td>
        <td style="padding: 5px"><strong>Price</strong></td>
    </tr>
    @foreach($orderDetailInfo as $itemDetail)
        <tr>
            <td style="padding: 5px">{{$itemDetail['course_name']}}</td>
            <td style="padding: 5px">{{$itemDetail['qty']}}</td>
            <?php $courseTotal = ($itemDetail['qty'] * $itemDetail['course_price'])?>
            <td style="padding: 5px">${{money_format('%i',$courseTotal)}}</td>
        </tr>

    @endforeach
    @foreach($promoDetails as $promoDetail)
    <tr>
        <td style="padding: 5px">{{$promoDetail->promo_code}} ({{$promoDetail->promo_desc}})</td>
        <td style="padding: 5px"><strong>Discount</strong></td>
        <td style="padding: 5px"> -${{money_format('%i',$promoDetail->promo_amt)}}</td>
    </tr>
    @endforeach
    <tr>
        <td style="padding: 5px"></td>
        <td style="padding: 5px"><strong>Total</strong></td>
        <td style="padding: 5px"> $0.00</td>
    </tr>   
    
    <tr>
        <td style="padding:5px; border-bottom:1px solid #cccccc;border-top:1px solid #cccccc;" colspan="3">
            <strong>Course Assignments</strong>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px">
            <strong>Course</strong>
        </td>
        <td style="padding: 5px">
            <strong>Assigned To</strong>
        </td>
    </tr>
    <?php foreach($assigneeDetails as $detailInfo){ ?>

    <tr>
       
        @if($detailInfo['session_name'] == '')
         <td style="padding: 5px"> {{$detailInfo['course_name']}}</td>
        @else
         <td style="padding: 5px"> {{$detailInfo['session_name']}}</td>
        @endif
        <?php $getAssignedUsers = CourseAssignment::where('order_detail_id',$detailInfo->id)->get(); ?>
        <td style="padding: 5px">
            @foreach($getAssignedUsers as $userInfo)

                {{$userInfo['first_name']}} {{$userInfo['last_name']}} ({{$userInfo['username']}})<br>

            @endforeach
        </td>
    </tr>
    <?php } ?>
     <tr>
        <td> ** To complete ANSI General Training requirements, the trainee must also demonstrate proficiency in actual, hands-on operation of all control functions of the device, and safe use at operating height and reach. This training must be directed by a qualified person. 

</td>
    </tr>
</table>
</body>
</html>



