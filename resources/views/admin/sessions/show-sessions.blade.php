@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    <a href="/admin">Return to Admin</a>
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! Session::get('success') !!}
        </div>
    @endif
     <div class="col-md-12 spacer">
         <div class="row">
            <div class="col-md-8" style="padding-left:0px;">
                <h3>Course Sessions</h3>
            </div>
            <div class="col-md-4 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <a href="/course_sessions/sync/" class="btn btn-primary" style="margin: 0px;">Update Sessions</a>
            </div>
        </div>   
    </div>   
    <div class="col-md-12 spacer">

        <div class="row userGridRowHeader">
            <div class="col-md-2 userGridColHeader" >Session Name</div>
            <div class="col-md-2 userGridColHeader" >Instructor Name</div>
            <div class="col-md-2 userGridColHeader" >Location</div>
            <div class="col-md-2 userGridColHeader" >Course Name</div>
            <div class="col-md-1 userGridColHeader" >Module Name</div>
            <div class="col-md-1 userGridColHeader" >Start Date</div>
            <div class="col-md-1 userGridColHeader" >End date</div>
            <div class="col-md-1 userGridColHeader" >Slots</div>

        </div>

        @foreach ($sessions as $session)
        <?php $imageName = str_replace('/', '', ""); ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem">{{$session->name}}</div>
                <div class="col-md-2 userGridColItem">{{$session->instructor_name}} </div>
                <div class="col-md-2 userGridColItem" >{{$session->location}}</div>
                <div class="col-md-2 userGridColItem" >{{ $session->course_name }}</div>
                <div class="col-md-1 userGridColItem" >{{$session->module_name}}</div>
                <div class="col-md-1 userGridColItem" >{{$session->start_date}}</div>
                <div class="col-md-1 userGridColItem" >{{$session->end_date}}</div>
                <div class="col-md-1 userGridColItem">{{$session->slots}}</div>

                
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-8 text-left" style="padding-left: 0px;">
                {{ $sessions->links() }}
            </div>
            
            <div class="col-md-4 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <a href="/course_sessions/sync/" class="btn btn-primary" style="margin: 0px;">Update Sessions</a>
            </div>
        </div>


        </div>


    </div>
</div>






@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
@stop

