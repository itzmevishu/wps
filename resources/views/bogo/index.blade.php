@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <h3>Buy One Get One</h3>
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>
    <div class="row well" style="padding-top:10px;margin-left:0px;margin-right:0px;">
        <div class="col-md-12 pull-right">
            <a href="/bogo/create" class="btn btn-info" role="button">Create Offer</a>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Course Name</th>
                <th>Offered Percentage</th>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($bogos as $key => $offer)
            <tr>
                <td>{{$offer->name}}</td>
                <td>{{$offer->offer}}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                {{ Form::open(array('url' => 'bogo/' . $offer->id, 'class' => 'pull-middle')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }}



                </td>
            </tr>
            @endforeach
            </tbody>
        </table>


    </div>
    <div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Please wait while we process your order.</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

@stop
@section('scripts')
@stop

