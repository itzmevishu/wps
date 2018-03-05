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
    <div class="row well" style="padding-top:10px;margin-left:0px;margin-right:0px;">
        <div class="col-md-12">
            <h4>Chose payment type</h4>
        </div>
        {{ Form::open(['url' =>env('APP_URL').'/select_payment_option']) }}

        <div class="row">
            <div class="col-md-6 text-left">
                <label for="payment_type">Pay By Cheque</label>
                {{ Form::radio('payment_type', 'cheque') }}

            </div>
            <div class="col-md-6 text-left">
                <label for="payment_type">Pay By Card</label>
                {{ Form::radio('payment_type', 'card') }}

            </div>
            <div class="row"><br/></div>
            {{ Form::submit('Begin Checkout',['class'=>'btn btn-primary btn-md','style'=>"margin-right:0px;"]) }}
            {{ Form::close() }}
        </div>
    </div>
    <div class="row">

    </div>


@stop
@section('scripts')
@stop


