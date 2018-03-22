@extends('layouts.default')
@section('content')

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            @if(! empty(Session::get('message')))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('message')}}
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <h1 class="well">Welcome Message</h1>
        <div class="col-lg-12 well">
            <div class="row">
                {{ Form::open(['url' => 'settings','id'=>'pivregister']) }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <textarea id="summernote" name="editordata">
                                <?php
                                    echo $welcomeMessage;
                                ?>
                            </textarea>
                            <div class="errors">{{$errors->first('editordata')}}</div>
                        </div>
                    </div>

                    {{ Form::submit('Save',['class'=>'btn btn-lg btn-info','tabindex'=>17]) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@stop
@section('scripts')

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                tabsize: 2,
                height: 100
            });
        });
    </script>
@stop

