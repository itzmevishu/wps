@extends('layouts.default')
@section('content')

    <div class="row" style="padding-top:25px;">
        <div class="col-md-12">
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
            @if(! empty(Session::get('successMsg')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('successMsg')}}
                </div>
            @endif



        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="">
        <a href="/admin">Return to Admin</a>
        <h3 class="ecomm_pageTitle">Category Home</h3>
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12" style="">
            <a href="/admin/category/view-all" class="btn btn-primary">View Categories</a>
            <a href="/admin/subcategory/view-all/2" class="btn btn-primary">View Sub-Categories</a>
            <a href="/admin/subcategory/view-all/3" class="btn btn-primary">View Tertiary-Categories</a>
        </div>

<!--
        <div class="col-md-12 spacer" style="">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Category</button>
        </div>
-->
    </div>
    <div class="row spacer">
        <div class="col-md-12" style="">
            <h4 class="ecomm_pageTitle">All Categories</h4>
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12" style="">
                @php($loop = 1)
                @if(is_array($categories) && !empty($categories))
                    @foreach($categories as $key => $category)
                        <div class="panel-group" id="{{strtolower(str_replace(' ', '', $key))}}">
                            <div class="panel panel-default">
                                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#{{strtolower(str_replace(' ', '', $key))}}" href="#collapse{{strtolower(str_replace(' ', '', $key))}}">{{$key}}
                            </a>
                        </h4>
                    </div>
                                    <div id="collapse{{strtolower(str_replace(' ', '', $key))}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="panel-group" id="accordion{{$loop}}">
                                @php($cloop = 1)
                                @if(is_array($category) && !empty($category))
                                    @foreach($category as $sKey => $sCategory)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion{{$loop}}" href="#collapse{{$loop}}{{$cloop}}">{{$sKey}}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$loop}}{{$cloop}}" class="panel-collapse collapse in">
                                            @if(is_array($sCategory) && !empty($sCategory))
                                                @foreach($sCategory as $tCategory)
                                                    <div class="panel-body">{{$tCategory['name']}}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    @php($cloop++)
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                        @php($loop++)
                    @endforeach
                @endif
        </div>
    </div>



    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['url' => env('APP_URL').'/admin/category/add']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-md-12">
                            {{Form::label('cat_name','Category Name')}}<br>
                            {{Form::text('cat_name',NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1])}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::submit('Add Category',['class'=>'btn btn-primary btn-md col-md-4 text-right','tabindex'=>3]) }}
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
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-body">
                    By deleting this category, you will be deleting the connection to any sub-categories underneath it. This will not delete the sub-categories.
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
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );
    </script>

    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });

        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>


@stop

