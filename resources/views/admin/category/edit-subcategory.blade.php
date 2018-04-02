
@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    
    

    <div class="col-md-12 spacer">
    <a href="/admin/subcategory/view-all">Return to Sub-Categories</a>
    <h3>
        @if($level == 3)
        Edit Teritiary Category
            @else
        Edit Sub-Category
        @endif
    </h3></div>
   
</div>
{{ Form::open(['url' => env('APP_URL').'/admin/subcategory/update/'.$subcategory->id]) }}
    <div class="row">
        <div class="col-md-4">
            @php($disable = ($level == 3)? 'disabled': '')
            {{Form::select('cat_name',$categories,$category_id,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Category', $disable])}}
        </div>
    </div>
@if($level == 3)
    <div class="row spacer">
        <div class="col-md-4">
            {{Form::select('sub_cat_name',$sub_categories,$subparent,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Category'])}}
        </div>
    </div>
@endif
    <div class="row spacer">
        <div class="col-md-4">
            {{Form::text('subcat_name',$subcategory->name,['class'=>'form-control col-md-12','maxlength'=>'80','tabindex'=>1])}}
        </div>            
    </div>

    <div class="row spacer">
        <div class="col-md-12">
            {{Form::select('courses[]',$courses,$savedCourses,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Courses ( CTRL + Mouse Click)','multiple'=>true,'size'=>15])}}
        </div>
    </div>

    <div class="row spacer">
        <div class="col-md-4">
            {{Form::hidden('level',$level)}}
            {{ Form::submit('Update Sub-Category',['class'=>'btn btn-primary btn-md col-md-12 text-right','tabindex'=>3]) }}
        </div>
    </div>
{{ Form::close() }}
@if($level == 3)
<div class="col-md-12 spacer"> 
    <div class="row userGridRowHeader">
        <div class="col-md-6 userGridColHeader" >Courses</div>
        <div class="col-md-3 userGridColHeader" ></div>
        <div class="col-md-3 userGridColHeader" ></div>

    </div>
    @if(count($subcatcourses) == 0)
        <div class="row altBG">
            <div class="col-md-6 userGridColItem">No courses found...</div>                
        </div>
    @else
        @foreach ($subcatcourses as $subcatcourse)
            <div class="row altBG">
                <div class="col-md-6 userGridColItem">{{$subcatcourse->name}}</div>
            </div>
        @endforeach  
    @endif
</div>
@endif

@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
@stop

