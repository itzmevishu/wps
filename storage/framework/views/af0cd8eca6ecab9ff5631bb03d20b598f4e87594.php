<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    
    

    <div class="col-md-12 spacer">
    <a href="/admin/subcategory/view-all">Return to Sub-Categories</a>
    <h3>
        <?php if($level == 3): ?>
        Edit Teritiary Category
            <?php else: ?>
        Edit Sub-Category
        <?php endif; ?>
    </h3></div>
   
</div>
<?php echo e(Form::open(['url' => env('APP_URL').'/admin/subcategory/update/'.$subcategory->id])); ?>

    <div class="row">
        <div class="col-md-4">
            <?php ($disable = ($level == 3)? 'disabled': ''); ?>
            <?php echo e(Form::select('cat_name',$categories,$category_id,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Category', $disable])); ?>

        </div>
    </div>
<?php if($level == 3): ?>
    <div class="row spacer">
        <div class="col-md-4">
            <?php echo e(Form::select('sub_cat_name',$sub_categories,$subparent,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Category'])); ?>

        </div>
    </div>
<?php endif; ?>
    <div class="row spacer">
        <div class="col-md-4">
            <?php echo e(Form::text('subcat_name',$subcategory->name,['class'=>'form-control col-md-12','maxlength'=>'80','tabindex'=>1])); ?>

        </div>            
    </div>
<?php if($level == 3): ?>
    <div class="row spacer">
        <div class="col-md-12">
            <?php echo e(Form::select('courses[]',$courses,$savedCourses,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Courses ( CTRL + Mouse Click)','multiple'=>true,'size'=>15])); ?>

        </div>
    </div>
<?php endif; ?>
    <div class="row spacer">
        <div class="col-md-4">
            <?php echo e(Form::hidden('level',$level)); ?>

            <?php echo e(Form::submit('Update Sub-Category',['class'=>'btn btn-primary btn-md col-md-12 text-right','tabindex'=>3])); ?>

        </div>
    </div>
<?php echo e(Form::close()); ?>

<?php if($level == 3): ?>
<div class="col-md-12 spacer"> 
    <div class="row userGridRowHeader">
        <div class="col-md-6 userGridColHeader" >Courses</div>
        <div class="col-md-3 userGridColHeader" ></div>
        <div class="col-md-3 userGridColHeader" ></div>

    </div>
    <?php if(count($subcatcourses) == 0): ?>
        <div class="row altBG">
            <div class="col-md-6 userGridColItem">No courses found...</div>                
        </div>
    <?php else: ?>
        <?php foreach($subcatcourses as $subcatcourse): ?>
            <div class="row altBG">
                <div class="col-md-6 userGridColItem"><?php echo e($subcatcourse->name); ?></div>
            </div>
        <?php endforeach; ?>  
    <?php endif; ?>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>