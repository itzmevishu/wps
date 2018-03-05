<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
         <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-5" style="">
                    <h2 class="ecomm_pageTitle">Assign Altec Sentry Learner</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12">
            <p> Please use the form to search for Learner. If no user is found, you will have the ability to create the user.</p>
            <h4>Course Name</h4>
            <span style="font-size:medium"><?php echo e($rowinfo->name); ?></span><br>
            <?php echo $rowinfo->options->course_details; ?><br>

        </div>
    </div>
    <div class="row well" id="searchform">
        <div class="col-md-12">
            <strong>Find Learner</strong><br>
            Check if the user you want to assign already has a learning account.
        </div>
        <div class="col-md-4" style="padding-top: 10px">

            <?php echo e(Form::text('email',NULL,['placeholder'=>'Search by Email (sample@domain.com)','class'=>'form-control','id'=>'email'])); ?>

            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="errors" id="email-req"></div>

        </div>
        <div class="col-md-6" style="padding-top: 10px">
            <button class="btn btn-primary btn-lg" id="searchName">Search</button>

        </div>
        <div class="col-md-12" style="padding-top:5px;">
            <p><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;Search requires a full email address.</p>
        </div>
    </div>

    <div class="row spacer well" id="foundUser" style="display:none">
        <div class="col-md-12">
            <strong>Is this the correct Altec Sentry Learner?</strong><br>
            <div style="margin-top:10px;"><span id="firstname"></span> <span id="lastname"></span> (<span id="email"></span>)</div>
            
            <?php echo e(Form::open(['url' => env('APP_URL').'/assign-course-other'])); ?>

            <?php echo e(Form::hidden('litmosid',NULL,['id'=>'litmosid'])); ?>

            <?php echo e(Form::hidden('firstname',NULL,['id'=>'FirstName'])); ?>

            <?php echo e(Form::hidden('lastname',NULL,['id'=>'LastName'])); ?>

            <?php echo e(Form::hidden('email',NULL,['id'=>'Email'])); ?>

            <?php echo e(Form::hidden('arraycnt',$arraycnt)); ?>

            <?php echo e(Form::hidden('rowid',$rowid)); ?>

            <?php echo e(Form::submit('Yes! Assign to Course',['class'=>'btn btn-primary','style'=>'margin-top:10px','tabindex'=>11])); ?>

            <button class="btn btn-primary spacer" style="margin-top:10px;" id="searchAgain">Return to Search</button>
            <?php echo e(Form::close()); ?>


        </div>

    </div>

    <div class=" row well" style="padding-top:20px;display:none;" id="newuser">

        <div class="row">
            <div class="col-md-12">
            <strong>Create a New Learner</strong><br>
            The user you searched for was not found. Please fill out the form to create an account.
            </div>
        </div>
        <?php echo e(Form::open(['url' => env('APP_URL').'/assign-course-new'])); ?>

        <div class="row spacer">
            <div class="col-md-12">
                <?php echo e(Form::label('first_name','First Name')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                <?php echo e(Form::text('first_name','',['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>1])); ?>

                <div class="errors"><?php echo e($errors->first('first_name')); ?></div>
            </div>
            <div class="col-md-12">
                <?php echo e(Form::label('last_name','Last Name')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                <?php echo e(Form::text('last_name','',['class'=>'form-control','maxlength'=>'100','autocomplete'=>'off','tabindex'=>2])); ?>

                <div class="errors"><?php echo e($errors->first('last_name')); ?></div>
            </div>
        
            <div class="col-md-12">
                <?php echo e(Form::label('email','Email Address')); ?>&nbsp;&nbsp;<span class="text-muted small">(required)</span><br>
                <?php echo e(Form::text('email','',['class'=>'form-control','maxlength'=>'255','autocomplete'=>'off','tabindex'=>3, 'id'=>'email_2'])); ?>

                <div class="errors"><?php echo e($errors->first('email')); ?></div>
            </div>           

      
        </div>
        <div class="row spacer">
            <div class="col-md-12 text-right">
                <?php echo e(Form::hidden('arraycnt',$arraycnt)); ?>

                <?php echo e(Form::hidden('rowid',$rowid)); ?>

                <?php echo e(Form::hidden('assign','Assign To Other')); ?>

                <?php echo e(Form::submit('Create New User',['class'=>'btn btn-primary','tabindex'=>13])); ?>

            </div>
        </div>
        <?php echo e(Form::close()); ?>


        </div>

    </div>

<div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Just a moment ...</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery(document).ready(function($){
        $('#searchform').show();
        $('#foundUser').hide();
        $('#newuser').hide();
        <?php if($show == 1){?>
        $('#newuser').show();
        <?php }?>

        $('#searchAgain').click(function(){
            $('#searchform').show();
            $('#foundUser').hide();
            $('#newuser').hide();
            $('#email').val('');

            return false;
        });

        function isEmail(email) {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
        }


        $('#searchName').click(function(){
            


            $('#email-req').text('');

            if($('#email').val() == ''){
                $('#email-req').text('Please enter an email adress to search.');
                return false;
            }

            if(!isEmail($('#email').val())){
                $('#email-req').text('Please enter an email adress to search.');
                return false;
            }

            $("#loading").show();
            $("#loading-text").show();
            $("#loading-img").show();

            var userEmail, token, url, data;
            token = $('input[name=_token]').val();
            userEmail = $('#email').val();
            url = 'check-email';
            data = {userEmail: userEmail};
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                data: data,
                type: 'POST',
                datatype: 'JSON',
                success: function (resp) {


                    if(resp == 404){
                        $('#newuser').show();
                        $('#foundUser').hide();
                        $('#email_2').val($('#email').val());
                        $('#email').val('');

                        $("#loading").hide();
                        $("#loading-text").hide();
                        $("#loading-img").hide();
                    }else{

                        respJson = JSON.parse(resp);

                        $('#foundUser').show();
                        $('#searchform').hide();
                        $('#newuser').hide();

                        $('#firstname').text(respJson.FirstName);
                        $('#lastname').text(respJson.LastName);
                        $('#email').text(respJson.UserName);
                        $('#litmosid').val(respJson.Id);
                        $('#FirstName').val(respJson.FirstName);
                        $('#LastName').val(respJson.LastName);
                        $('#Email').val(respJson.UserName);
                        $('#CompanyName').val(respJson.CompanyName);

                        $("#loading").hide();
                        $("#loading-text").hide();
                        $("#loading-img").hide();

                    }
                }
            });
        });
    });

    $(function(){
        $('#phone').keyup(function()
        {
            this.value = this.value.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3');
            //alert ("OK");
        });
    });

    jQuery(document).ready(function($){
        $("#state_req").hide();
        $("#zip_req").hide();


        if($('#countrydd').val() != ''){

            if($('#countrydd').val() != 'United States' && $('#countrydd').val() != 'Canada'){
                $("#state_req").hide();
                $("#zip_req").hide();
            }else{
                $("#state_req").show();
                $("#zip_req").show();
            }

            $.get("<?php echo e(url('api/stateDropDown')); ?>",
                    { option: $('#countrydd').val() },
                    function(data) {
                        var model = $('#statedd');
                        model.empty();
                        if (data != ''){
                            $("#statedd").show();
                            $("#statetext").hide();
                            model.append("<option value=''>Choose State</option>");
                            $.each(data, function(index, element) {
                                if($("#statetext").val() == element.name){
                                    model.append("<option value='"+ element.name +"' selected>" + element.name + "</option>");
                                }else{
                                    model.append("<option value='"+ element.name +"'>" + element.name + "</option>");
                                }
                            });
                        }else{
                            $("#statedd").hide();
                            $("#statetext").show();
                        }
                    });
        }

        $('#countrydd').change(function(){
            $('#statedd').empty();
            $("#statedd").hide();
            $("#statetext").hide();
            $.get("<?php echo e(url('api/stateDropDown')); ?>",
                    { option: $(this).val() },
                    function(data) {
                        var model = $('#statedd');
                        model.empty();
                        if (data != ''){
                            $("#statedd").show();
                            model.append("<option value=''>Choose State</option>");
                            $.each(data, function(index, element) {
                                model.append("<option value='"+ element.name +"'>" + element.name + "</option>");
                            });
                        }else{
                            $("#statetext").show();
                        }
                    });
            if($('#countrydd').val() != 'United States' && $('#countrydd').val() != 'Canada'){
                $("#state_req").hide();
                $("#zip_req").hide();
            }else{
                $("#state_req").show();
                $("#zip_req").show();
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>