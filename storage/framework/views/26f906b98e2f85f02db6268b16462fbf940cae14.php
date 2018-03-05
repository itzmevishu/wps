<?php $__env->startSection('content'); ?>

    <div class="row" style="padding-top:50px;">

        <div class="col-md-12 text-left" style="padding-bottom: 10px">
            <a href="/store-catalog">&laquo; Course List</a>
        </div>

    </div>

    <div class="row" style="height: 600px;overflow-x: auto;overflow-y: auto;background-color: #ffffff;padding-top:10px;padding-bottom:10px;">

        <div class="col-md-3 session-center" style="">
            <img src="<?php echo e($courseImage); ?>" style="width:100%">
            <div class="usdPrice" style="padding-top:15px;font-size:18px;">
                <strong>Price:</strong> &#36;<?php echo e($coursePrice); ?>

            </div>
        </div>
        <div class="col-md-9">
            <p><?php echo html_entity_decode($courseInfo->Description); ?></p>
        </div>


        <?php
        $moduleArray = [];
        $sessionID = '';
        //dd($moduleInfo);
        foreach ($moduleInfo as $key=>$module_info){

        $sessionListResponse = App\Functions\litmosAPI::apiGetSessionInfo($input,$courseInfo->Id,$module_info->Id);
        array_push($moduleArray,$module_info->Id);
        ?>
        <div class="col-md-12" style="padding-top: 10px">
            <div class="col-md-12" style="border-bottom: 1px solid #ccc;padding-left: 0px;">
                <strong style="font-size: large"><?php echo e($module_info->Name); ?></strong>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 25px;">
            <?php foreach($sessionListResponse as $comp): ?>
                <?php

                if($sessionID <> $comp->Id){
                    $sessionID = $comp->Id;
                }else{
                    continue;
                }

                preg_match( '/\/Date\((\d+)([+-]\d{4})\)/', $comp->StartDate, $startDate );
                preg_match( '/\/Date\((\d+)([+-]\d{4})\)/',  $comp->EndDate, $endDate );
                $z_eur_price =($coursePrice * $currencyRate);
                $z_eur_price =number_format($z_eur_price, 2, '.', '');



                $details = '<p style="line-height: 25px;padding-top:5px;"><strong>'.$comp->Name.'</strong><br><strong>Dates:</strong> '.date( 'M d, Y', $startDate[1]/1000 ).' - '.date( 'M d, Y', $endDate[1]/1000).'<br><strong>Time:</strong> '.$comp->Days[0]->StartTime.' to '.' '. $comp->Days[0]->EndTime.' '.$comp->TimeZone.'<br><strong>Location:</strong> '.$comp->Location.'<br><strong>Instructor:</strong> '.$comp->InstructorName.'</p>';

                if($comp->Accepted >= $comp->Slots){
                    $displayRegister = 'disabled';
                    $seatText = 'FULL';
                } else{
                    $displayRegister = '';
                    $seatText = $comp->Slots-$comp->Accepted;
                }

                $irmaTest= Cart::search(array('id'=>$courseInfo->Id));
                ?>

                <?php if(date( 'Y-m-d', $startDate[1]/1000 ) >=date( 'Y-m-d')): ?>

                    <div class="row sessionRow_<?php echo e($module_info->Id); ?> altBG" id="<?php echo e($comp->Id); ?>" style="padding:10px;margin:2px;">
                        <label class="sessionLabels">
                            <div class="col-md-1" style="text-align: center;">
                                <div class="dateResponsiveL">
                                    <div class ="session-date">
                                        <?php if(date( 'd', $endDate[1]/1000 ) != date( 'd', $startDate[1]/1000 )): ?>
                                            <?php echo e(date( 'd', $startDate[1]/1000 )); ?>-<?php echo e(date( 'd', $endDate[1]/1000 )); ?>

                                        <?php else: ?>
                                            <?php echo e(date( 'd', $startDate[1]/1000 )); ?>

                                        <?php endif; ?>

                                    </div>
                                    <div class ="session-month">
                                        <?php echo e(date( 'M', $startDate[1]/1000 )); ?>

                                    </div>
                                </div>
                                <div class="dateResponsiveR">
                                    <div class ="session-seats">
                                        <?php echo e($seatText); ?>

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
                                <?php if($seatText != "FULL"): ?>
                                    <?php echo e(Form::open(['url' =>env('APP_URL').'/add-to-cart', 'class' => "addToCart"])); ?>

                                    <?php echo e(Form::hidden('course_id',$courseInfo->Id)); ?>

                                    <?php echo e(Form::hidden('course_sku',$courseInfo->Code)); ?>

                                    <?php echo e(Form::hidden('module_array',implode(",",$moduleArray))); ?>

                                    <?php echo e(Form::hidden('course_name',$courseInfo->Name)); ?>

                                    <?php echo e(Form::hidden('course_price',$coursePrice)); ?>

                                    <?php echo e(Form::hidden('course_type','single session')); ?>

                                    <?php echo e(Form::hidden('course_details',$details)); ?>

                                    <?php echo e(Form::hidden('session_id_'.$module_info->Id,$sessionID)); ?>

                                    <?php echo e(Form::hidden('free_course',0)); ?>

                                    <?php echo e(Form::hidden('session_cnt',count($moduleInfo),['id'=>'session_cnt'])); ?>



                                    <?php echo e(Form::submit('Add To Cart',['class'=>'btn btn-primary btn-sm ',$displayRegister])); ?>

                                    <?php echo e(Form::close()); ?>

                                <?php endif; ?>

                            </div>
                        </label>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php } ?>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <span class="pull-right">
                <a href="/show-cart" class="btn btn-primary pull-left">Show Cart</a>
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



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
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
                });
            });


        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>