<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
   <a href="/admin/category/home">Return to Category Home</a>
    <h3>Categories</h3>


    <div class="col-md-12 spacer text-right">
        <div class="row">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Category</button>
        </div>
    </div>
    <div class="col-md-12 spacer">
        <div class="row userGridRowHeader">
            <div class="col-md-3 userGridColHeader" >Name</div>
            <div class="col-md-3 userGridColHeader" ></div>
            <div class="col-md-3 userGridColHeader" ></div>

        </div>
        <?php if(count($categories) == 0): ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem">No categories found...</div>
            </div>
        <?php else: ?>
            <?php foreach($categories as $category): ?>
                <div class="row altBG">
                    <div class="col-md-2 userGridColItem"><?php echo e($category->name); ?></div>
                    <div class="col-md-2 userGridColItem"><a href="/admin/category/edit/<?php echo e($category->id); ?>">Edit</a></div>
                    <div class="col-md-2 userGridColItem"><a href="#" data-href="/admin/category/delete/<?php echo e($category->id); ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo e(Form::open(['url' => env('APP_URL').'/admin/category/add'])); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Category</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo e(Form::label('cat_name','Category Name')); ?><br>
                        <?php echo e(Form::text('cat_name',NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1])); ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo e(Form::submit('Add Category',['class'=>'btn btn-primary btn-md col-md-4 text-right','tabindex'=>3])); ?>

                         </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

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




<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });

        $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>