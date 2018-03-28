
@extends('layouts.default')
@section('content')
<style>
    .glyphicon { margin-right:5px; }
    .thumbnail
    {
        margin-bottom: 20px;
        padding: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .item.list-group-item
    {
        float: none;
        width: 100%;
        background-color: #fff;
        margin-bottom: 10px;
    }
    .item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
    {
        background: #428bca;
    }

    .item.list-group-item .list-group-image
    {
        margin-right: 10px;
    }
    .item.list-group-item .thumbnail
    {
        margin-bottom: 0px;
    }
    .item.list-group-item .caption
    {
        padding: 9px 9px 0px 9px;
    }
    .item.list-group-item:nth-of-type(odd)
    {
        background: #eeeeee;
    }

    .item.list-group-item:before, .item.list-group-item:after
    {
        display: table;
        content: " ";
    }

    .item.list-group-item img
    {
        float: left;
    }
    .item.list-group-item:after
    {
        clear: both;
    }
    .list-group-item-text
    {
        margin: 0 0 11px;
    }

</style>
    <div class="row well"  style="margin-top:25px;">
        <div class="col-md-12" style="padding-left:0px;">

            <p>
                @php
                    $user = Auth::user();
                @endphp
                @if($user)
                    <strong style="font-size:large">Welcome {{$user->first_name}}!</strong>
                @else
                    <strong style="font-size:large">Welcome!</strong>
                @endif
            </p>

            <p>Welcome to the WPS Learning center!</p>
            @if(Auth::check())

                @if(! empty(Session::get('freeFAM')))
                    <div class="alert alert-info" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {!! Session::get('freeFAM') !!}
                    </div>
                @endif
            @endif

            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>

    <div class="row" style="background-color: #fff;padding-top: 5px;padding-bottom: 25px;padding-left: 25px;padding-right: 25px;">

        <div class="row">
            <div class="col-md-6 btn-group">
                <h4>Available Sessions
                <a href="#" id="list" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-th-list"></span>List
                </a>
                <a href="#" id="grid" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-th"></span>Grid
                </a>
                </h4>
            </div>
            <div class="col-md-6">
                <span class="pull-right">
                    {!! Form::open(['url' => 'course_sessions', 'id' =>"search"]) !!}
                    {{ Form::select('session_sort', ['name_asc' => 'Name (A-Z)', 'name_desc'=> 'Name (Z-A)', 'location_asc' => 'Location (A-Z)', 'location_desc' => 'Location (Z-A)', 'start_date_asc' => 'Date Asc', 'start_date_desc' => 'Date Desc'], $sort, array('id' => 'search')) }}
                    {!! Form::close() !!}
                </span>
                <span class="pull-right">
                    Sort By:&nbsp;
                </span>

            </div>
        </div>


        <div class="row">
            @if(count($sessions) == 0)
                <div class="col-sm-3 spacer" style="padding-top:10px;">
                    No sessions found...
                </div>

            @else
                <div class="container">
                    <div id="products" class="row list-group">
                        @foreach($sessions as $session)

                        <div class="item  col-xs-4 col-lg-4">
                            <div class="thumbnail">
                                <img class="group list-group-image" style="width:400px;height:250px;" src="{{$session->course->image}}" alt="" />
                                <div class="caption">
                                    <h4 class="group inner list-group-item-heading">
                                        {{$session['name']}}</h4>
                                    <p class="group inner list-group-item-text">
                                    <h4><small>Instructor: {{$session['instructor_name']}}</small></h4>
                                    <h4><small>Start Date: {{$session['start_date']}}</small></h4>
                                    </p>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <p class="lead">&nbsp;</p>
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <a class="btn btn-success" href="/confirm-course?courseid={{$session['course_id']}}&sid={{$session['session_id']}}">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>





@stop
@section('scripts')

    <script>
        $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".glyphicon-chevron-right").removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-down");
        }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-right");
        });

        $(function () {
            var __sort = "name_asc";
            var __search = "all";

            $("#search").change(function () {

                var __sort = $("#search option:selected").val();
                window.location.replace("{{ env('APP_URL') }}/iltsessions/"+ __search +"/" + __sort);
            });


        });


        $(document).ready(function() {
            $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
            $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
        });

    </script>

@stop

