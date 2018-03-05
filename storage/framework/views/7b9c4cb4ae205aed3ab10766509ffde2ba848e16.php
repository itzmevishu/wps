<?php $__env->startSection('content'); ?>

    <div class="row" style="padding-top:50px;">

        <div class="col-md-12 text-left" style="padding-bottom: 10px">
            <a href="/store-catalog">&laquo; Course List</a>
        </div>

    </div>

    <div class="row" style="height: 400px;overflow-x: auto;overflow-y: auto;background-color: #ffffff;padding-top:10px;padding-bottom:10px;">
        <div class="col-md-3 session-center">
            <img src="<?php echo e($courseImage); ?>" style="width:100%">
            <div class="usdPrice" style="padding-top:15px;font-size:18px;">
                <strong>Price:</strong> &#36;<?php echo e($coursePrice); ?>

            </div>
        </div>
        <div class="col-md-9">
        <p><h3><?php echo html_entity_decode($courseInfo->Name); ?></h3></p>
            <p><?php echo html_entity_decode($courseInfo->Description); ?></p>
        </div>


    <?php ($free_course_id = 0); ?>
    <?php if(!empty($free_course)): ?>

        <?php 
            if (File::exists('images/courses/'.$free_course->image.'.png'))
                    {
                        $image_file = 'images/courses/'.$free_course->image.'.png';
                    }elseif (File::exists('images/courses/'.$free_course->image.'.jpg')) {
                        $image_file = 'images/courses/'.$checkCatalog['image'].'.jpg';
                    }else{
                        $image_file ='http://via.placeholder.com/350x150';
                    }
         $free_course_id = $free_course->id;
         ?>
                <p><h3>Offering free course:</h3></p>
            <div class="col-md-3 session-center">
                <img src="<?php echo e($image_file); ?>" style="width:100%">
                <div class="usdPrice" style="padding-top:15px;font-size:18px;">
                    <strong>Price:</strong> Free
                </div>
            </div>
            <div class="col-md-9">
                <p><h3><?php echo html_entity_decode($free_course->name); ?></h3></p>
                <p><?php echo html_entity_decode($free_course->description); ?></p>
            </div>

    <?php endif; ?>
        </div>
    <div class="row" style="padding-top:10px;">
        <div class="col-md-6 text-left session-reset-btn">
           
        </div>
        <div class="col-md-6 text-right session-add-btn">

            <?php echo e(Form::open(['url' =>env('APP_URL').'/add-to-cart'])); ?>

            <?php echo e(Form::hidden('course_id',$courseInfo->Id)); ?>

            <?php echo e(Form::hidden('course_sku',$courseInfo->Code)); ?>

            <?php echo e(Form::hidden('module_id','')); ?>

            <?php echo e(Form::hidden('session_id','')); ?>

            <?php echo e(Form::hidden('module_array','')); ?>

            <?php echo e(Form::hidden('course_name',$courseInfo->Name)); ?>

            <?php echo e(Form::hidden('course_desc',$courseInfo->EcommerceLongDescription)); ?>

            <?php echo e(Form::hidden('course_price',$coursePrice)); ?>


            <?php echo e(Form::hidden('course_type','single course')); ?>

            <?php echo e(Form::hidden('course_details','')); ?>

            <?php echo e(Form::hidden('free_course',$free_course_id)); ?>

            <?php echo e(Form::submit('Add to Cart',['class'=>'btn btn-primary btn-sm '])); ?>

            <?php echo e(Form::close()); ?>

        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>