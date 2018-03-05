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
                            <img src="https://www.altec.com/site/themes/altec/images/altec-logo.jpg" style="width:100%; max-width:300px;">
                        </td>

                        <td style="width:380px;text-align: right;">
                            Invoice #: LITMOS-<?php echo e($orderInfo['id']); ?><br>
                            Date: <?php echo e(Date('m/d/Y',strtotime($orderInfo['created_at']))); ?><br>
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
                            <?php echo e($billingDetails->address); ?><br>
                            <?php echo e($billingDetails->city); ?>, <?php echo e($billingDetails->state); ?><br>
                            <?php echo e($billingDetails->country); ?>, <?php echo e($billingDetails->zip_code); ?>

                        </td>

                        <td style="width:380px;text-align: right;">
                            <?php echo e($billingDetails->provider_name); ?><br>
                            <?php echo e($billingDetails->npi); ?>, <?php echo e($billingDetails->ptan); ?><br>
                            <?php echo e($billingDetails->phone); ?>

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

        <?php foreach($orderDetailInfo as $itemDetail): ?>
            <?php $courseTotal = ($itemDetail['qty'] * $itemDetail['course_price']); ?>
            <tr>
                <td style="width:300px;text-align: left;"> <?php echo e($itemDetail['course_name']); ?></td>
                <td style="width:200px;text-align: left;"><?php echo e($itemDetail['qty']); ?></td>
                <td style="width:200px;text-align: left;">$<?php echo e(number_format($courseTotal, 2)); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>