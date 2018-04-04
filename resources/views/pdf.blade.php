<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WPS GHA Check Payment Invoice</title>
    <style>

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 18cm;
            height: 25cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: right;
        }


        #details {
            margin-bottom: 50px;
        }

        .seminar {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #seminar .to {
            color: #777777;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: left;
        }

        #invoice h4 {
            color: #0087C3;
            font-size: 1.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0  0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3{
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks{
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices{
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 90%;
            height: 40px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: left;
        }


        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }


    </style>

</head>

<body>
<header class="clearfix">
    <div id="logo">
        <img src="http://wpsgha.litmos.com/upload/media/26616/logo/561975ca-3fbe-49f6-bf9d-85f9ecbc8ec9.png" style="width:180px;height:90px;">
    </div>
    <div id="company">

    </div>
</header>
<main>
    <div>
        <strong> <p style="text-align: center;">Payment is due before your registration can be completed and your seat is guaranteed. </p></strong>
        <p>
            To ensure your registration for this event can be completed timely, please make sure each person wishing to
            attend has a user profile in WPS GHA’s Learning Center.  If an attendee does not yet have one, please have
            them go to <a href="wpsghalearningcenter.com">wpsghalearningcenter.com</a> to create a user profile.  If payment is received after the seminar is
            full, a full refund check will be issued.
        </p>
    </div>
    <div id="details" class="clearfix">
        <div id="client">
            <div class="to">INVOICE TO:</div>
            <h2 class="name">{{$user->name}}</h2>
            <div class="address">{{ $billingDetails->address }}</div>
            <div class="email"><a href="mailto:{{$user->email}}">{{$user->email}}</a></div>
        </div>
        <div id="invoice">
            <h4>Invoice #: WPS-{{$orderInfo['id']}}</h4>
            <div class="date">Date: {{Date('m/d/Y',strtotime($orderInfo['created_at']))}}</div>
        </div>
    </div>


    <div class="row">
            <div class="">Seminar Name: {{isset($check_payment_details->seminar_name)?$check_payment_details->seminar_name:'-'}}</div>
            <div class="">Seminar Date: {{isset($check_payment_details->seminar_date)? Date('m/d/Y',strtotime($check_payment_details->seminar_date)) :''}}</div>
    </div>

    <div class="row">
        <hr style=" border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));"/>
    </div>

    <div class="row">
        <div class="column">
            <strong>Attendees:</strong>
        </div>
    </div>

        @if(is_array($attendees))
            @php($row = 0)
            @foreach($attendees as $key => $attendeeInfo)
                @if( $row == 0)
                    <div class="row">
                @endif
                <div class="column">
                    <span style="font-weight: 500;">Attendee {{$key + 1}}:</span>
                    <p style="line-height: 9px;"><span style="font-weight: bold;">Name</span>: {{$attendeeInfo->first_name}} {{$attendeeInfo->last_name}}</p>
                    <p style="line-height: 9px;"><span style="font-weight: bold;">Email</span>:{{$attendeeInfo->username}}</p>
                </div>
                        @php($row++)
                @if( $row == 2 || count($attendees) == $key+1)
                @php($row = 0)
                    </div>
                @endif
            @endforeach
        @endif
    <div class="row">
        <hr style="margin-bottom: 20px;border-bottom: 1px solid #AAAAAA;"/>
    </div>
    <div class="clearfix row">
        <div>
            <strong>Please make checks payable to WPS GHA and mail to the address below</strong>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <span>Check Amount: </span> ${{isset($check_payment_details->check_amount)?$check_payment_details->check_amount:0}}
        </div>
        <div class="column">
            <span>Check Number:</span> {{isset($check_payment_details->check_number)?$check_payment_details->check_number:0}}
        </div>
    </div>
    <div class="row header">
        <h4>Please mail to:</h4>
    </div>
    <div class="row">
        <div class="column">
            <strong>Iowa, Kansas, Missouri, Nebraska, National</strong>
            <p style="line-height: 9px;">WPS GHA – J5</p>
            <p style="line-height: 9px;">PO Box 8696</p>
            <p style="line-height: 9px;">Madison, WI  53708-8696</p>
        </div>
        <div class="column">
            <strong>Indiana, Michigan</strong>
            <p style="line-height: 9px;">WPS GHA – J8</p>
            <p style="line-height: 9px;">PO Box 14172</p>
            <p style="line-height: 9px;">Madison, WI  53708-0172 </p>
        </div>
    </div>
</main>
<footer>
    <p  style="width: 100%;text-align: center;">
        <strong>Cancellation/Refund Policy</strong>
    </p>
    All cancellation requests must be sent to <a href="mailto:surveymail@wpsic.com">surveymail@wpsic.com</a> prior to the date of the scheduled event.  A full or partial
    refund will be issued based on contractual expenses we will incur.  No refunds will be issued for cancellations received on
    or after the date of the event.
</footer>
</body>
</html>