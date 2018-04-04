<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 1/22/2018
 * Time: 2:57 PM
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: vkalappagari
 * Date: 1/22/2018
 * Time: 11:46 AM
 */
?>

@extends('layouts.default')
@section('content')
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>
    <h3>WPS GHA Check Payment</h3>
    {{ Form::open(['url' => env('APP_URL').'/create_cheque_payment', 'id' => "bt-hsf-checkout-form", 'method' => 'post']) }}
    <div class="well" style="padding:20px 20px;">
        <div class="spacer row">
            <div class="col-md-6">
                {{Form::label('seminar_name','Seminar Name')}}<br>
                {{Form::text('seminar_name',NULL,['class'=>'form-control','maxlength'=>'100'])}}
                <div class="errors">{{$errors->first('seminar_name')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('seminar_date','Seminar Date')}}<br>
                {{Form::text('seminar_date',NULL,['class'=>'form-control','maxlength'=>'100', 'id' => 'seminar_date'])}}
                <div class="errors">{{$errors->first('seminar_date')}}</div>
            </div>
        </div>

        <div class="spacer row">
            <div class="col-md-6">
                {{Form::label('city','City')}}&nbsp;&nbsp;<span class="text-muted small" >(required)</span><br>
                {{Form::text('city',NULL,['class'=>'form-control','maxlength'=>'100','id'=>'city'])}}
                <div class="errors">{{$errors->first('city')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('state','State')}}&nbsp;&nbsp;<span class="text-muted small" id="state_req">(required)</span>
                {{Form::select('state',$states,NULL,['placeholder' => 'Please Select State','class'=>'form-control','id'=>'statedd'])}}
                <div class="errors">{{$errors->first('state')}}</div>
            </div>
        </div>
        <div class="spacer row"></div>
        <div class="alert alert-info">
            <strong> <p  class="text-center">Payment is due before your registration can be completed and your seat is guaranteed. </p></strong>
            <p>
            To ensure your registration for this event can be completed timely, please make sure each person wishing to
            attend has a user profile in WPS GHA’s Learning Center.  If an attendee does not yet have one, please have
            them go to wpsghalearningcenter.com to create a user profile.  If payment is received after the seminar is
            full, a full refund check will be issued.
            </p>
        </div>

        <div class="page-header">
            <h3>Provider Information</h3>
        </div>
        <div class="spacer row">
            <div class="col-md-6">
                {{Form::label('provider_name','Provider Name')}}<br>
                {{Form::text('provider_name',$profile->provider_name,['class'=>'form-control','maxlength'=>'100'])}}
                <div class="errors">{{$errors->first('provider_name')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('npi','National Provider Identifier (NPI)')}}<br>
                {{Form::text('npi',$profile->npi,['class'=>'form-control','maxlength'=>'100'])}}
                <div class="errors">{{$errors->first('npi')}}</div>
            </div>
        </div>
        <div class="spacer row">
            <div class="col-md-6">
                {{Form::label('ptan','Provider Transaction Access Number (PTAN)')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                {{Form::text('ptan',$profile->ptan,['class'=>'form-control','maxlength'=>'100','id'=>'address_line_1'])}}
                <div class="errors">{{$errors->first('ptan')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('phone','Work Phone',['id'=>'phone'])}}&nbsp;&nbsp;<span class="text-muted small" id="phone">(required)</span>
                {{Form::text('phone',$profile->phone_number,['class'=>'form-control','maxlength'=>'10', 'id'=>'zip_code'])}}
                <div class="errors">{{$errors->first('phone')}}</div>
            </div>
        </div>

        <div class="spacer row">
            <div class="col-md-6">
                {{Form::label('address','Address')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                {{Form::textarea('address',NULL,['class'=>'form-control','id'=>'address', 'cols' => 50, 'rows' => 5])}}
                <div class="errors">{{$errors->first('address')}}</div>
            </div>

        </div>

        <div class="page-header">
            <h4>Please make checks payable to WPS GHA and mail to the address below.</h4>
        </div>

        <div class="spacer row">
            <div class="col-md-6">
                {{Form::label('check_amount','Check Amount')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                {{Form::text('check_amount',NULL,['class'=>'form-control','maxlength'=>'100','id'=>'check_amount'])}}
                <div class="errors">{{$errors->first('ptan')}}</div>
            </div>
            <div class="col-md-6">
                {{Form::label('check_number','Check Number')}}&nbsp;&nbsp;<span class="text-muted small" id="phone">(required)</span>
                {{Form::text('check_number',NULL,['class'=>'form-control','maxlength'=>'10','id'=>'check_number'])}}
                <div class="errors">{{$errors->first('phone')}}</div>
            </div>
        </div>
        @if(is_array($attendees))
        <div class="spacer row"></div>
        <div class="page-header">
            <h2>Attendees:</h2>
        </div>

                <div class="spacer row">
                    @foreach($attendees as $key => $attendeeInfo)
                    <div class="container spacer col-md-6">
                        <h4>Attendee {{$key + 1}}:</h4>
                        <p style="line-height: 9px;"><strong>Name</strong>: {{$attendeeInfo['firstname']}} {{$attendeeInfo['lastname']}}</p>
                        <p style="line-height: 9px;"><strong>Email</strong>:{{$attendeeInfo['litmosusername']}}</p>
                    </div>
                     @endforeach
                </div>

        @endif

        <div class="page-header">
            <h4>Please mail checks to:</h4>
        </div>
        <div class="container spacer row">
            <div class="container col-md-6">
                <strong>Iowa, Kansas, Missouri, Nebraska, National</strong>
                <p style="line-height: 9px;">WPS GHA – J5</p>
                <p style="line-height: 9px;">PO Box 8696</p>
                <p style="line-height: 9px;">Madison, WI  53708-8696</p>
            </div>
            <div class="col-md-6">
                <strong>Indiana, Michigan</strong>
                <p style="line-height: 9px;">WPS GHA – J8</p>
                <p style="line-height: 9px;">PO Box 14172</p>
                <p style="line-height: 9px;">Madison, WI  53708-0172 </p>
            </div>
        </div>
        <div class="spacer row"></div>
        <div class="alert alert-warning">
            <strong> <p  class="text-center">Cancellation/Refund Policy </p></strong>
            <p>
                All cancellation requests must be sent to <a href="mailto:surveymail@wpsic.com">surveymail@wpsic.com</a> prior to the date of the scheduled event.  A full or partial
                refund will be issued based on contractual expenses we will incur.  No refunds will be issued for cancellations received on
                or after the date of the event.
            </p>
        </div>
    </div>
    <div class="spacer row">
        <div class="col-md-12 text-right">
            {{ Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-lg']) }}
        </div>
    </div>
    {{ Form::close() }}
    <div class="row">

    </div>


@stop
@section('scripts')
    <script>
        $( function() {
            $( "#seminar_date" ).datepicker();
        } );
    </script>
@stop



