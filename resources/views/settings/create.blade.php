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
        <h4 class="well">Application Settings</h4>
        <div class="col-lg-12 well">
            <div class="row">
                {{ Form::open(['url' => 'settings','id'=>'pivregister']) }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {{Form::label('editordata','Welcome Message')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                            <textarea id="summernote" name="editordata">
                                <?php
                                    echo isset($settings['welcome']) ? $settings['welcome'] : '';
                                ?>
                            </textarea>
                            <div class="errors">{{$errors->first('editordata')}}</div>
                        </div>
                    </div>

                    <div class="row spacer">
                        <div class="col-md-12">
                            {{Form::label('litmos_key','Litmos Key')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                            {{Form::text('litmos_key',isset($settings['LITMOS_KEY']) ? $settings['LITMOS_KEY'] : '',['class'=>'form-control','autocomplete'=>'off','tabindex'=>2])}}
                            <div class="errors">{{$errors->first('litmos_key')}}</div>
                        </div>
                    </div>

                    <div class="row spacer">
                        <div class="col-md-12">
                            {{Form::label('litmos_source','Litmos Source')}}&nbsp;&nbsp;<span class="text-muted small">*</span><br>
                            {{Form::text('litmos_source',isset($settings['LITMOS_SOURCE']) ? $settings['LITMOS_SOURCE'] : '',['class'=>'form-control','placeholder' => 'wps','autocomplete'=>'off','tabindex'=>3])}}
                            <div class="errors">{{$errors->first('litmos_source')}}</div>
                        </div>
                    </div>

                    <div class="row spacer">
                        <div class="col-md-12">
                            {{ Form::submit('Save',['class'=>'btn btn-lg btn-info','tabindex'=>4]) }}
                        </div>
                    </div>

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

