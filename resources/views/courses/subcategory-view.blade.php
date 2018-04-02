
@extends('layouts.default')
@section('content')

    
    <div class="row" style="margin-top:25px;background-color: #fff;padding-top: 5px;padding-bottom: 25px;padding-left: 25px;padding-right: 25px;">

        <div class="row">
            <div class="col-md-12">
                @if(isset($free))
                    <h4>Available Free Courses</h4>
                @else
                    <h4>Courses Available in {{$parentName}} / {{$childName}}</h4>
                @endif
                
            </div>
        </div>


        <div class="row">
        @if(count($courses)>0)
            @foreach($courses as $course)
                    @php

                        $image_file =  $course['image'];

                        $now = time(); // or your date as well
                        $your_date = strtotime($course['created_at']);
                        $datediff = $now - $your_date;

                        $days =  round($datediff / (60 * 60 * 24));


                        $access_till_date = strtotime($course['access_till_date']);
                        $end_date_diff = $now - $access_till_date;

                        $end_days =  round($end_date_diff / (60 * 60 * 24));

                    @endphp
                
                <div class="col-sm-3 spacer" style="border-bottom: 1px solid #ccc;padding-top:10px;">
                    <div style="position: relative">
                        @if($course['price'] == 0)
                            <div><div class="ribbon-wrapper-green"><div class="ribbon-green">FREE</div></div><img src="{{$image_file}}" style="width:258px;height:258px;"></div>
                        @elseif($days <= 30)
                            <div><div class="ribbon-wrapper-green"><div class="ribbon-green">NEW</div></div><img src="{{$image_file}}" style="width:258px;height:258px;"></div>
                        @elseif($end_days <= 7)
                            <div><div class="ribbon-wrapper-green"><div class="ribbon-green">Closing Soon</div></div><img src="{{$image_file}}" style="width:258px;height:258px;"></div>
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
        @else
            <div class="col-sm-3">
                    <div style="position: relative">
                        No Courses found...
                    </div>
                </div>
        @endif
            
        </div>
    </div>
{{ $courses->links() }}


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

