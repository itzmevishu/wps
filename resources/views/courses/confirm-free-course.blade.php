
@extends('layouts.default')
@section('content')

    <div class="row" style="padding-top:25px;">

        <div class="col-md-12 text-left">
            <a href="/choose-free-course">&laquo; Free Course List</a>
        </div>

    </div>
    <div class="row spacer">
        <div class="col-md-12 text-left" style="padding-bottom: 10px">
            <h3>Confirm Your Free Course</h3>
        </div>
    </div>

    <div class="row" style="height: 400px;background-color: #ffffff;padding-top:10px;padding-bottom:10px;">

        <div class="col-md-12">
            <h3><?php echo html_entity_decode($courseInfo->Name); ?></h3>
        </div>

        <div class="col-md-3 session-center">
        <?php $imageName = str_replace('/', '', $courseImage); ?>
            <img src="/images/courses/{{$imageName}}.png" style="width:100%">    
        </div>
        <div class="col-md-9 session-center">
            <p><?php echo html_entity_decode($courseInfo->Description); ?></p>
        </div> 
    </div>
    <div class="row spacer">
        <div class="col-md-6 text-left">
            <a href="/choose-free-course" class="btn btn-secondary">No, I'd like a different course.</a>
        </div>
        <div class="col-md-6 text-right">
            <a href="/assign-free-course/{{$courseid}}/{{$courseInfo->Id}}" class="btn btn-primary">Yes! I want this course.</a>
        </div>
    </div>

   

@stop
@section('scripts')

@stop

