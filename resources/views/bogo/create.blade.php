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
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <h3>Buy One Get One</h3>
            @if(! empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <h1 class="well">Create Offer</h1>
        <div class="col-lg-12 well">
            <div class="row">
                {{ Form::open(['url' => 'bogo','id'=>'pivregister']) }}
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                {{Form::label('course_id','Course')}}<br>
                                {{Form::select('course_id',$courses,NULL,['placeholder' => 'Select Course','class'=>'form-control','id'=>'promoType','tabindex'=>9])}}
                                <div class="errors">{{$errors->first('course_id')}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                {{Form::label('offer_percentage','Offer Percentage')}}<br>
                                {{Form::text('offer_percentage','',['class'=>'form-control col-md-12','maxlength'=>'80','tabindex'=>2])}}
                                <div class="errors">{{$errors->first('offer_percentage')}}</div>
                            </div>
                        </div>
                        {{ Form::submit('Create Offer',['class'=>'btn btn-lg btn-info','tabindex'=>17]) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop
@section('scripts')
@stop

