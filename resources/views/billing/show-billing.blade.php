
@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h3 class="ecomm_pageTitle">Billing Info</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="padding-top:10px;">
        <div class="col-md-12">
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
            @if(! empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
            <div class="col-md-6 well" style="height:400px;">
                <div class="row"  style="">
                    <div class="col-md-12" style="text-align:left;">
                        <h4>Your Billing Address</h4>
                    </div>
                </div>
                {{ Form::open(['url' => env('APP_URL').'/update-address']) }}
                <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >

                        <div class="col-md-6" style="">
                            {{Form::label('address1','Address')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                            {{Form::text('address1',NULL,['class'=>'form-control','maxlength'=>'255','tabindex'=>5])}}
                            <div class="errors">{{$errors->first('address1')}}</div>
                        </div>
                        <div class="col-md-6" style="">
                            {{Form::label('address2','Address 2')}}<br>
                            {{Form::text('address2',NULL,['class'=>'form-control','maxlength'=>'255','tabindex'=>6])}}

                        </div>
                </div>
                <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >

                        <div class="col-md-6" style="">
                            {{Form::label('country','Country')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                            {{Form::select('country',$countries,NULL,['placeholder' => 'Please Select Your Country','class'=>'form-control','id'=>'countrydd','tabindex'=>7])}}

                            <div class="errors">{{$errors->first('country')}}</div>
                        </div>
                        <div class="col-md-6" style="">
                            {{Form::label('state','State')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                            {{Form::text('state',NULL,['class'=>'form-control','maxlength'=>'40','style'=>'display:none','id'=>'statetext','tabindex'=>8])}}
                            {{Form::select('state',$states,NULL,['placeholder' => 'Please Select Your State','class'=>'form-control','id'=>'statedd','tabindex'=>8])}}
                            <div class="errors">{{$errors->first('state')}}</div>
                        </div>
                </div>
                <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >

                        <div class="col-md-6" style="">
                            {{Form::label('city','City')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                            {{Form::text('city',NULL,['class'=>'form-control','maxlength'=>'40','tabindex'=>9])}}
                            <div class="errors">{{$errors->first('city')}}</div>
                        </div>
                        <div class="col-md-6" style="">
                            {{Form::label('zipCode','Postal Code')}}&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                            {{Form::text('zipCode',NULL,['class'=>'form-control','maxlength'=>'20','tabindex'=>10])}}
                            <div class="errors">{{$errors->first('zipCode')}}</div>
                        </div>
                </div>
                <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >
                    {{ Form::submit('Update Address',['class'=>'btn btn-primary btn-lg pull-right','tabindex'=>13]) }}
                </div>

                {{ Form::close() }}
            </div>
                <div class="col-md-6 ">

                    <div class="col-md-12 well" style="height:400px;">
                        <div class="row"  style="">
                            <div class="col-md-12" style="text-align:left;">
                                <h4>Your Credit Card</h4>
                            </div>
                        </div>
                        {{ Form::open(['url' => env('APP_URL').'/update-card']) }}
                        <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >
                            <div class="col-md-12">
                            {{Form::label('cardHolderName','Name on card')}}<br>
                            {{Form::text('cardHolderName',null,['class'=>'form-control','maxlength'=>'100'])}}
                            <div class="errors">{{$errors->first('cardHolderName')}}</div>
                            </div>
                        </div>
                        <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >

                                <div class="col-md-5">
                                    {{Form::label('card_type','Type')}}<br>
                                    {{Form::select('card_type', array(
                                        'AmericanExpress' => 'American Express',
                                        'Discover' => 'Discover',
                                        'MasterCard' => 'Mastercard',
                                        'Visa' => 'Visa'),null,['class'=>'form-control'])}}
                                    <div class="errors">{{$errors->first('card_type')}}</div>
                                </div>
                                <div class="col-md-7">
                                    {{Form::label('card_number','Card Number')}}<br>
                                    {{Form::text('card_number',null,['class'=>'form-control','maxlength'=>'19'])}}
                                    <div class="errors">{{$errors->first('card_number')}}</div>
                                </div>

                        </div>

                        <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >

                                <div class="col-md-3">
                                    {{Form::label('exp_month','Exp Month')}}<br>
                                    {{Form::selectRange('exp_month', 1, 12,null,['class'=>'form-control'])}}
                                    <div class="errors">{{$errors->first('exp_month')}}</div>
                                </div>
                                <div class="col-md-3">
                                    {{Form::label('exp_year','Exp Year')}}<br>
                                    {{Form::selectYear('exp_year', date("Y"), date("Y")+5,null,['class'=>'form-control'])}}
                                    <div class="errors">{{$errors->first('exp_year')}}</div>
                                </div>
                                <div class="col-md-6">
                                    {{Form::label('card_code','Security Code')}}<br>
                                    {{Form::text('card_code',null,['class'=>'form-control','maxlength'=>'10'])}}
                                    <div class="errors">{{$errors->first('card_code')}}</div>
                                </div>
                        </div>
                        <div class="row"  style="padding-bottom: 10px;padding-top: 10px;" >
                            {{Form::hidden('updateCredit','yes')}}
                            {{ Form::submit('Update Credit Card',['class'=>'btn btn-primary btn-lg pull-right']) }}
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>

        </div>
    </div>


@stop
@section('scripts')

@stop

