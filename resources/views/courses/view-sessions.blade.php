@extends('layouts.default')
@section('content')

    <div class="row" style="padding-top:50px;">

        <div class="col-md-12 text-left" style="padding-bottom: 10px">
            <a href="/store-catalog">&laquo; Course List</a>
        </div>

    </div>

    <div class="row" style="height: 600px;overflow-x: auto;overflow-y: auto;background-color: #ffffff;padding-top:10px;padding-bottom:10px;">

        <div class="col-md-3 session-center" style="">
            <img src="{{$courseImage}}" style="width:100%">
            <div class="usdPrice" style="padding-top:15px;font-size:18px;">
                <strong>Price:</strong> &#36;{{$coursePrice}}
            </div>
        </div>
        <div class="col-md-9">
            <p><?php echo html_entity_decode($courseInfo->description); ?></p>
        </div>


        <?php
        $moduleArray = [];
        $sessionID = '';

        foreach ($moduleInfo as $key => $module_info){

        #$sessionListResponse = App\Functions\litmosAPI::apiGetSessionInfo($input,$courseInfo->course_id,$module_info->lms_module_id);

        $sessionListResponse = $module_info->sessions;
        array_push($moduleArray,$module_info->lms_module_id);


        ?>
        <div class="col-md-12" style="padding-top: 10px">
            <div class="col-md-12" style="border-bottom: 1px solid #ccc;padding-left: 0px;">
                <strong style="font-size: large">{{$module_info->name}}</strong>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 25px;">
            @foreach ($sessionListResponse as $comp)
                <?php

                if($sessionID <> $comp->session_id){
                    $sessionID = $comp->session_id;
                }else{
                    continue;
                }

                preg_match( '/\/Date\((\d+)/', $comp->StartDate, $startDate );
                preg_match( '/\/Date\((\d+)/',  $comp->EndDate, $endDate );
                $z_eur_price =($coursePrice * $currencyRate);
                $z_eur_price =number_format($z_eur_price, 2, '.', '');

                $details = '<p style="line-height: 25px;padding-top:5px;"><strong>'.$comp->name.'</strong><br>';

                $details .= '<strong>Dates:</strong> '.date( 'M d, Y', strtotime($comp->start_date) ).' - '.date( 'M d, Y', strtotime($comp->end_date)).'<br>';

                //$details .= '<strong>Time:</strong> '.date( 'G A', strtotime($comp->start_date) ).' to '.' '. date( 'G A', strtotime($comp->end_date)).' UTC<br>';
                $details .= '<strong>Location:</strong> '.$comp->location.'<br>';
                $details .= '<strong>Instructor:</strong> '.$comp->instructor_name.'</p>';
                if(empty($comp->slots)){
                    $displayRegister = '';
                    $seatText = 'No Limit';
                }elseif($comp->accepted >= $comp->slots){
                    $displayRegister = 'disabled';
                    $seatText = 'FULL';
                } else{
                    $displayRegister = '';
                    $seatText = $comp->slots - $comp->accepted;
                }
                $irmaTest= Cart::search(array('id'=>$courseInfo->course_id));
                ?>

                @if( date( 'Y-m-d', strtotime($comp->start_date) ) >=date( 'Y-m-d'))

                    <div class="row sessionRow_{{$module_info->lms_module_id}} altBG" id="{{$comp->session_id}}" style="padding:10px;margin:2px;">
                        <label class="sessionLabels">
                            <div class="col-md-1" style="text-align: center;">
                                <div class="dateResponsiveL">
                                    <div class ="session-date">
                                        @if(date( 'd', strtotime($comp->end_date) ) != date( 'd', strtotime($comp->start_date) ))
                                            {{date( 'd', strtotime($comp->start_date) )}}-{{date( 'd', strtotime($comp->end_date) )}}
                                        @else
                                            {{date( 'd', strtotime($comp->start_date) )}}
                                        @endif

                                    </div>
                                    <div class ="session-month">
                                        {{date( 'M', strtotime($comp->start_date) )}}
                                    </div>
                                </div>
                                <div class="dateResponsiveR">
                                    <div class ="session-seats">
                                        {{$seatText}}
                                    </div>
                                    <div class ="session-seat-message">
                                        Seats Remain
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-9">
                                <div style="padding-bottom:10px;float:left;width:100%;">
                                    <?php echo html_entity_decode($details); ?>
                                </div>

                            </div>

                            <div class="col-md-2 text-center">
                                @if($seatText != "FULL")
                                    {{ Form::open(['url' =>env('APP_URL').'/add-to-cart', 'class' => "addToCart"]) }}
                                    {{Form::hidden('course_id',$courseInfo->course_id)}}
                                    {{Form::hidden('course_sku',$courseInfo->code)}}
                                    {{Form::hidden('module_array',implode(",",$moduleArray))}}
                                    {{Form::hidden('course_name',$courseInfo->name)}}
                                    {{Form::hidden('course_price',$coursePrice)}}
                                    {{Form::hidden('course_type','single session')}}
                                    {{Form::hidden('course_details',$details)}}
                                    {{Form::hidden('session_id_'.$module_info->lms_module_id,$sessionID)}}
                                    {{Form::hidden('free_course',0)}}
                                    {{Form::hidden('session_cnt',count($moduleInfo),['id'=>'session_cnt'])}}


                                    {{ Form::submit('Add To Cart',['class'=>'btn btn-primary btn-sm ',$displayRegister]) }}
                                    {{ Form::close() }}
                                @endif

                            </div>
                        </label>
                    </div>
                @endif
            @endforeach
        </div>

        <?php } ?>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <span class="pull-right">
                <a href="/show-cart" class="btn btn-primary pull-left">View Cart</a>
            </span>
            <span class="pull-right" style="padding-right: 10px;">
                <a href="/" class="btn btn-primary pull-left">Continue Shopping</a>
            </span>

        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Successfully added course to cart.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

            $( ".addToCart" ).submit(function( event ) {
                event.preventDefault();

                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission


                $.ajax({
                    url : post_url,
                    type: request_method,
                    data : form_data
                }).done(function(response){
                    $("#cartCount").html(response.count);
                    $('#myModal').modal('show');
                }).error(function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status == 401){
                        window.location.href = '/login';
                    }

                });
            });


        });
    </script>
@stop
