@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    <div class="col-md-12">

        <a href="/admin"><div> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> Return to Admin Home</div></a>

        @if(! empty(Session::get('errormsg')))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('errormsg')}}
        </div>
        @endif
        @if(! empty(Session::get('successMsg')))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('successMsg')}}
        </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="">
        <div class="row ecomm_pageTitleWrapper">
            <div class="col-md-5" style="">
                <h3 class="ecomm_pageTitle">Admin | All Purchases</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p>Select a date range to download all purchases.</p>
    </div>
</div>
    {{ Form::open(array('url'=>env('APP_URL').'/admin/pull-report','method'=>'POST')) }}
    <!--
        {{Form::text('dateRange',NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>3])}}
        -->
<div class="row">
    <div class="col-md-6">

        <label for="from">From</label>
            {{Form::text('from',NULL,[ 'id' => 'from', 'class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1])}}
    </div>
    <div class="col-md-6">
        <label for="to">to</label>
        {{Form::text('to',NULL,[ 'id' => 'to' ,'class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>2])}}
    </div>
</div>
<div class="row spacer">
    <div class="col-md-3">
        <div>
            <label class="form-check-label">Order Type:</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-check">
            <input class="form-check-input" name="report_type" type="radio" id="radio100" value="check">
            <label class="form-check-label" for="report_type">Check</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="report_type" type="radio" id="radio101" value="card">
            <label class="form-check-label" for="report_type">Card</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="report_type" type="radio" id="radio102" value="all" checked>
            <label class="form-check-label" for="report_type">ALL</label>
        </div>
    </div>

</div>
<div class="row spacer">

    <div class="col-md-6">
        {{ Form::submit('Get Report',['class'=>'btn btn-primary btn-md col-md-4 text-right','tabindex'=>13]) }}
    </div>
</div>
    {{ Form::close() }}






@stop
@section('scripts')
<script>
   // $('input[name="dateRange"]').daterangepicker();

</script>
<script>
    $( function() {
        var dateFormat = "mm/dd/yy",
            from = $( "#from" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                .on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
            to = $( "#to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
                .on( "change", function() {
                    from.datepicker( "option", "maxDate", getDate( this ) );
                });

        function getDate( element ) {
            var date;
            try {
                date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
                date = null;
            }

            return date;
        }
    } );
</script>
@stop

