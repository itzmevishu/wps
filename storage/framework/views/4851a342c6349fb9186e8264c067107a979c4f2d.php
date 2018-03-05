<?php $__env->startSection('content'); ?>

    <div class="row" style="padding-top:25px;">
        <div class="col-md-12">
            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
            <?php if(! empty(Session::get('successMsg'))): ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('successMsg')); ?>

                </div>
            <?php endif; ?>



        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="">
        <a href="/admin">Return to Admin</a>
        <h3 class="ecomm_pageTitle">Category Home</h3>
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12" style="">
            <a href="/admin/category/view-all" class="btn btn-primary">View Categories</a>
            <a href="/admin/subcategory/view-all/2" class="btn btn-primary">View Sub-Categories</a>
            <a href="/admin/subcategory/view-all/3" class="btn btn-primary">View Tertiary-Categories</a>
        </div>


        <div class="col-md-12 spacer" style="">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Category</button>
        </div>

    </div>
    <div class="row spacer">
        <div class="col-md-12" style="">
            <h4 class="ecomm_pageTitle">All Categories</h4>
        </div>
    </div>
    <div class="row spacer">
        <div class="col-md-12" style="">
                <?php ($loop = 1); ?>
                <?php foreach($categories as $key => $category): ?>
                    <div class="panel-group" id="<?php echo e(strtolower(str_replace(' ', '', $key))); ?>">
                        <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#<?php echo e(strtolower(str_replace(' ', '', $key))); ?>" href="#collapse<?php echo e(strtolower(str_replace(' ', '', $key))); ?>"><?php echo e($key); ?>

                        </a>
                    </h4>
                </div>
                <div id="collapse<?php echo e(strtolower(str_replace(' ', '', $key))); ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="panel-group" id="accordion<?php echo e($loop); ?>">
                            <?php ($cloop = 1); ?>
                            <?php foreach($category as $sKey => $sCategory): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion<?php echo e($loop); ?>" href="#collapse<?php echo e($loop); ?><?php echo e($cloop); ?>"><?php echo e($sKey); ?>

                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo e($loop); ?><?php echo e($cloop); ?>" class="panel-collapse collapse in">
                                    <?php foreach($sCategory as $tCategory): ?>
                                        <div class="panel-body"><?php echo e($tCategory['name']); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php ($cloop++); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                    <?php ($loop++); ?>
                <?php endforeach; ?>
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
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );
    </script>

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