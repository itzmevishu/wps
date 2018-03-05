
@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:0px;">
        <div class="col-md-12" style="padding-left:0px;">

            
                <h3 class="ecomm_pageTitle">Free Course</h3>

                <p>You are eligible to choose ONE of the following courses as part of your training.</p>

            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>

    <div class="row" style="background-color: #fff;padding-top: 5px;padding-bottom: 25px;padding-left: 25px;padding-right: 25px;">

        <div class="row" style="padding-top:10px;">
            @foreach($courses as $course)
                
                <div class="col-sm-3">
                    <div style="position: relative">
                        <?php $imageName = str_replace('/', '', $course['image']); ?>
                        <div><img src="/images/courses/{{$imageName}}.png" style="width:100%"></div>
                        <div style="min-height:60px;"><h4>{{$course['lms_title']}}</h4></div>
                        
                                                <div style="min-height:50px;left: 15px;right: 15px;">
                            <a href="/confirm-free-course?courseid={{$course['lms_course_id']}}" class="btn btn-primary pull-left">Choose Course</a>

                        </div>
                    </div>
                </div>
            @endforeach
            
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

