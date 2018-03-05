
@extends('layouts.default')
@section('content')


    <div class="row" style="padding-top:25px;">
        <div class="col-md-12">
             @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {!! Session::get('success') !!}
                </div>
            @endif

                <a href="/admin">Return to Admin</a>
                <h3 class="ecomm_pageTitle">Add Course Photo</h3>
                <!--
                 <p>Use the Litmos user bulk upload code as the name of your image file.</p>
                <p>You can find the upload code in the Litmos admin for each course, in the "settings" tab.</p>
                -->
        </div>
    </div>
    {!! Form::open(array('url'=>env('APP_URL').'/admin/photos/upload','method'=>'POST', 'files'=>true)) !!}

    <div class="row spacer">
        <div class="col-md-12 well">

            <div class="row">
                <div class="col-md-4">
                    {{ Form::label('id', 'Select Course', array('class' => 'mylabel')) }}
                    {{Form::select('course',$courses ,$course_id,['id'=> 'course', 'class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Course'])}}
                    <p class="errors">{!!$errors->first('course')!!}</p>
                </div>
            </div>

            <div class="row spacer">
                <div class="col-md-12">
                    {{ Form::label('image', 'Upload Image', array('class' => 'mylabel')) }}
                    {!! Form::file('image') !!}
                </div>
            </div>
            <div class="row spacer">
                <div class="col-md-12">
                    {!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}

                    <p class="errors">{!!$errors->first('image')!!}</p>
                    @if(Session::has('error'))
                        <p class="errors">{!! Session::get('error') !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}






@stop
@section('scripts')
    <script>
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );
    </script>


@stop

