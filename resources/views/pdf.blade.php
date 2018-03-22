<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        .invoice-box table {
            text-align: left;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="3">
                <table>
                    <tr>
                        <td class="title">
                            <img src="http://wpsgha.litmos.com/upload/media/26616/logo/561975ca-3fbe-49f6-bf9d-85f9ecbc8ec9.png" style="width:100%; max-width:300px;">
                        </td>

                        <td style="width:380px;text-align: right;">
                            Invoice #: LITMOS-{{$orderInfo['id']}}<br>
                            Date: {{Date('m/d/Y',strtotime($orderInfo['created_at']))}}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="3">
                <table>
                    <tr>
                        <td style="width:300px;text-align: left;">
                            <strong>Billing Address: </strong><br/>
                            {{ $billingDetails->address  }}<br />
                            {{ $billingDetails->city }}, {{ $billingDetails->state }}<br />
                            {{ $billingDetails->country }}, {{ $billingDetails->zip_code }}
                        </td>

                        <td style="width:380px;text-align: right;">
                            Provider: {{ $billingDetails->provider_name }}<br />
                            NPI: {{ $billingDetails->npi }}<br/>
                            PTAN: {{ $billingDetails->ptan }}<br />
                            Phone: {{ $billingDetails->phone }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">

            <td style="width:300px;text-align: left;">
                Course
            </td>

            <td style="width:200px;text-align: left;">
                Seats
            </td>
            <td style="width:200px;text-align: left;">
                Price
            </td>
        </tr>

        @foreach($orderDetailInfo as $itemDetail)
            <?php $courseTotal = ($itemDetail['qty'] * $itemDetail['course_price']); ?>
            <tr>
                <td style="width:300px;text-align: left;"> {{$itemDetail['course_name']}}</td>
                <td style="width:200px;text-align: left;">{{$itemDetail['qty']}}</td>
                <td style="width:200px;text-align: left;">${{number_format($courseTotal, 2)}}</td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>