@extends('layouts.default')
@section('content')

    <div class="row" style="padding-top:50px;">

        <div class="col-md-12 text-left" style="padding-bottom: 10px">
            <a href="/store-catalog">&laquo; Course List</a>
        </div>

    </div>

    <div class="row" style="height: 400px;overflow-x: auto;overflow-y: auto;background-color: #ffffff;padding-top:10px;padding-bottom:10px;">
        <div class="col-md-3 session-center">
            <img src="{{$courseImage}}" style="width:100%">
            <div class="usdPrice" style="padding-top:15px;font-size:18px;">
                <strong>Price:</strong> &#36;{{$coursePrice}}
            </div>
        </div>
        <div class="col-md-9">
        <p><h3><?php echo html_entity_decode($courseInfo->Name); ?></h3></p>
            <p><?php echo html_entity_decode($courseInfo->Description); ?></p>
        </div>


    @php($free_course_id = 0)
    @if(!empty($free_course))

        @php
            if (File::exists('images/courses/'.$free_course->image.'.png'))
                    {
                        $image_file = 'images/courses/'.$free_course->image.'.png';
                    }elseif (File::exists('images/courses/'.$free_course->image.'.jpg')) {
                        $image_file = 'images/courses/'.$checkCatalog['image'].'.jpg';
                    }else{
                        $image_file ='http://via.placeholder.com/350x150';
                    }
         $free_course_id = $free_course->id;
        @endphp
                <p><h3>Offering free course:</h3></p>
            <div class="col-md-3 session-center">
                <img src="{{$image_file}}" style="width:100%">
                <div class="usdPrice" style="padding-top:15px;font-size:18px;">
                    <strong>Price:</strong> Free
                </div>
            </div>
            <div class="col-md-9">
                <p><h3><?php echo html_entity_decode($free_course->name); ?></h3></p>
                <p><?php echo html_entity_decode($free_course->description); ?></p>
            </div>

    @endif
        </div>
    <div class="row" style="padding-top:10px;">
        <div class="col-md-6 text-left session-reset-btn">
           
        </div>
        <div class="col-md-6 text-right session-add-btn">

            {{ Form::open(['url' =>env('APP_URL').'/add-to-cart']) }}
            {{Form::hidden('course_id',$courseInfo->Id)}}
            {{Form::hidden('course_sku',$courseInfo->Code)}}
            {{Form::hidden('module_id','')}}
            {{Form::hidden('session_id','')}}
            {{Form::hidden('module_array','')}}
            {{Form::hidden('course_name',$courseInfo->Name)}}
            {{Form::hidden('course_desc',$courseInfo->EcommerceLongDescription)}}
            {{Form::hidden('course_price',$coursePrice)}}

            {{Form::hidden('course_type','single course')}}
            {{Form::hidden('course_details','')}}
            {{Form::hidden('free_course',$free_course_id)}}
            {{ Form::submit('Add to Cart',['class'=>'btn btn-primary btn-sm ']) }}
            {{ Form::close() }}
        </div>
    </div>


@stop
@section('scripts')
@stop
