@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    
    

    <div class="col-md-12 spacer">
    <a href="/admin/category/view-all">Return to Categories</a>
    <h3>Edit Category</h3></div>
   
</div>
{{ Form::open(['url' => env('APP_URL').'/admin/category/update/'.$category->id]) }}
    <div class="row">
        <div class="col-md-5">
            {{Form::text('name',$category->name,['class'=>'form-control col-md-12','maxlength'=>'80','tabindex'=>1])}}
        </div> 
    </div>
@if(is_array($subcategories))
     <div class="row spacer">
        <div class="col-md-5">
            {{Form::select('subcats[]',$subcategories,null,['class'=>'form-control col-md-4','multiple'=>'multiple','size'=>20,'placeholder'=>'Choose Sub-Category (CTRL + Mouse Click)'])}}
        </div>
    </div>
@endif
<div class="modal-body ">
    <div class="row">
        <div class="col-md-12">
            {{Form::label('cat_name','Course Name')}}<br>
            {{Form::select('courses[]',$courses,$selectedCourses,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Courses ( CTRL + Mouse Click)','multiple'=>true,'size'=>15])}}
        </div>
    </div>
</div>
    <div class="row spacer">         
        <div class="col-md-5">
            {{ Form::submit('Update Category',['class'=>'btn btn-primary btn-md col-md-12 text-right','tabindex'=>3]) }}
        </div>
    </div>
{{ Form::close() }}


@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
@stop

