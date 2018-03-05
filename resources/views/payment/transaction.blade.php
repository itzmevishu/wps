@extends('layouts.default')
@section('content')
<br/><br/><br/><br/>
<!--Display Payment Confirmation-->
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h4>
            <?php echo($customer->name.', Thank you for your Order!');?><br/><br/>
            Shipping Address: </h4>
         Name<br/>
        Address 1<br/>
        Address 2 <br/>
        City<br/>
        500036<br/>
        County<br/>

        <h4>Transaction ID : <?php echo($result->transaction->id);?> <br/>
            State : Approved  <br/>
            Total Amount: <?php echo($result->transaction->amount);?> &nbsp;
            <?php echo($result->transaction->currencyIsoCode); ?> <br/>
        </h4>
        <br/>
        Return to <a href="/">home page</a>.
    </div>
    <div class="col-md-4"></div>
</div>

@stop
@section('scripts')
@stop