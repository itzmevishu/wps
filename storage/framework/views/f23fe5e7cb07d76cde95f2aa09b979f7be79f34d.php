<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    
    

    <div class="col-md-12 spacer">
    <a href="/admin/category/view-all">Return to Categories</a>
    <h3>Edit Category</h3></div>
   
</div>
<?php echo e(Form::open(['url' => env('APP_URL').'/admin/category/update/'.$category->id])); ?>

    <div class="row">
        <div class="col-md-5">
            <?php echo e(Form::text('name',$category->name,['class'=>'form-control col-md-12','maxlength'=>'80','tabindex'=>1])); ?>

        </div> 
    </div>
     <div class="row spacer">
        <div class="col-md-5">
            <?php echo e(Form::select('subcats[]',$subcategories,null,['class'=>'form-control col-md-4','multiple'=>'multiple','size'=>20,'placeholder'=>'Choose Sub-Category (CTRL + Mouse Click)'])); ?>

        </div>
    </div>   
    <div class="row spacer">         
        <div class="col-md-5">
            <?php echo e(Form::submit('Update Category',['class'=>'btn btn-primary btn-md col-md-12 text-right','tabindex'=>3])); ?>

        </div>
    </div>
<?php echo e(Form::close()); ?>



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