@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    <a href="/admin/category/home">Return to Category Home</a>
    <h3>
        @if($level == 3)
            Tertiary Categories
        @else
            Sub-Categories
        @endif
    </h3>
    

    <div class="col-md-12 spacer text-right">
        <div class="row">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                @if($level == 3)
                    Add Tertiary Category
                @else
                    Add Sub-Category
                @endif
            </button>
        </div>
    </div>
    <div class="col-md-12 spacer"> 
        <div class="row userGridRowHeader">
            <div class="col-md-3 userGridColHeader" >Sub-Category</div>
            <div class="col-md-3 userGridColHeader" >Category</div>
            <div class="col-md-3 userGridColHeader" ></div>
            <div class="col-md-3 userGridColHeader" ></div>


        </div>
        @if(count($result) == 0)
            <div class="row altBG">
                <div class="col-md-2 userGridColItem">No sub-categories found...</div>                
            </div>
        @else
            @foreach ($result as $category)

                <div class="row altBG">
                    <div class="col-md-3 userGridColItem">{{$category->subcategory_name}}</div>
                    <div class="col-md-3 userGridColItem">{{$category->category_name}}</div>
                    <div class="col-md-3 userGridColItem"><a href="/admin/subcategory/edit/{{$category->id}}">Edit</a></div>
                    <div class="col-md-2 userGridColItem"><a href="#" data-href="/admin/subcategory/delete/{{$category->id}}" data-toggle="modal" data-target="#confirm-delete">Delete</a></div>
                </div>
            @endforeach  
        @endif
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(['url' => env('APP_URL').'/admin/subcategory/add']) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Sub-Category</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        {{Form::select('cat_name',$categories,NULL,['id'=> 'rootCategory', 'class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Category'])}}
                    </div>
                </div>
                @if($level == 3)
                <div class="row spacer">
                    <div class="col-md-12">
                        {{Form::select('sub_cat_name',$sub_categories,NULL,['id'=> 'subCategory','class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Sub-Category'])}}
                    </div>
                </div>
                @endif
                <div class="row spacer">
                    <div class="col-md-12">
                        {{Form::text('subcat_name',NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Enter Sub Category Name'])}}
                    </div>
                </div>
                @if($level == 3)
                <div class="row spacer">
                    <div class="col-md-12">
                        {{Form::select('courses[]',$courses,NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Courses ( CTRL + Mouse Click)','multiple'=>true,'size'=>15])}}
                    </div>
                </div>
                @endif
            </div>

            <div class="modal-footer text-right">
                <div class="row">
                    <div class="col-md-12">
                        {{ Form::submit('Add Sub-Category',['class'=>'btn btn-primary btn-md col-md-4 text-right','tabindex'=>3]) }}
                         </div>
                </div>
            </div>
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Are you sure you want to delete this sub-category?
            </div>
            <div class="modal-body">
                By deleting this sub-category, you will be deleting the connection to any courses underneath it. This will not delete the courses.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
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

        $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

        $(document).ready(function($){
            $('#rootCategory').change(function(){
                $.get("{{ url('categories')}}",
                    { option: $(this).val() },
                    function(data) {
                        $('#subCategory').empty();
                        $.each(data, function(key, element) {
                            $('#subCategory').append("<option value='" + key +"'>" + element + "</option>");
                        });
                    });
            });
        });
    </script>
@stop