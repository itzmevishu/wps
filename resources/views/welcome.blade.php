@extends('layouts.default')
@section('content')

    <div class="row well"  style="margin-top:25px;">
        <div class="col-md-12" style="padding-left:0px;">

             <p>
                @if(Auth::check())
                    <strong style="font-size:large">Welcome {{$userAuth->first_name}}!</strong>
                @else
                     <strong style="font-size:large">Welcome!</strong>
                @endif
            </p>

                <p>Welcome to the WPS Learning Center!</p>
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
            <div class="col-md-12">
                <h4>Available Courses</h4>
                @if($searchTerm != '')<p style="font-style: italic;font-weight: bold">Searching for: {{$searchTerm}}</p>@endif
            </div>
        </div>


        <div class="row">
            
        @if(count($courses) == 0)
        <div class="col-sm-3 spacer" style="padding-top:10px;">
        No courses found...
        </div>

        @else
            @foreach($courses as $course)
                @php
                    $image_file =  $course['image'];
                @endphp

                <div class="col-sm-3 spacer" style="border-bottom: 1px solid #ccc;padding-top:10px;">
                    <div style="position: relative">
                        <a href="/confirm-course?courseid={{$course['course_id']}}" style="text-decoration:none;">
                        @if($course['price'] == 0)
                            <div><div class="ribbon-wrapper-green"><div class="ribbon-green">FREE</div></div><img src="{{$image_file}}" style="width:100%"></div>
                        @else
                            <div><img src="{{$course['image']}}" style="width:258px;height:258px;"></div>
                        @endif

                        <div style="min-height:60px;"><h4>{{$course['name']}}</h4></div>
                        </a>
                        <div style="min-height:50px;left: 15px;right: 15px;">
                        <a href="/confirm-course?courseid={{$course['course_id']}}" class="btn btn-primary pull-left">View Details</a>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
            
        </div>
    </div>
{{ $courses->appends(['search_terms' => $searchTerm])->links() }}




@stop
@section('scripts')

    <script>
        $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".glyphicon-chevron-right").removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-down");
        }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-right");
        });

    </script>

@stop

