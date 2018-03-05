<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <h1 class="well">Create Offer</h1>
        <div class="col-lg-12 well">
            <div class="row">
                <?php echo e(Form::open(['url' => 'bogo','id'=>'pivregister'])); ?>

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <?php echo e(Form::label('course_id','Course')); ?><br>
                                <?php echo e(Form::select('course_id',$courses,NULL,['placeholder' => 'Select Course','class'=>'form-control','id'=>'promoType','tabindex'=>9])); ?>

                                <div class="errors"><?php echo e($errors->first('course_id')); ?></div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <?php echo e(Form::label('course_id_offered','Course Offered')); ?><br>
                                <?php echo e(Form::select('course_id_offered',$courses,NULL,['placeholder' => 'Select free course','class'=>'form-control','id'=>'promoType','tabindex'=>9])); ?>

                                <div class="errors"><?php echo e($errors->first('course_id_offered')); ?></div>
                            </div>
                        </div>
                        <?php echo e(Form::submit('Create Offer',['class'=>'btn btn-lg btn-info','tabindex'=>17])); ?>

                    </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>