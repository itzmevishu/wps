<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    <a href="/admin/category/home">Return to Category Home</a>
    <h3>
        <?php if($level == 3): ?>
            Tertiary Categories
        <?php else: ?>
            Sub-Categories
        <?php endif; ?>
    </h3>
    

    <div class="col-md-12 spacer text-right">
        <div class="row">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                <?php if($level == 3): ?>
                    Add Tertiary Category
                <?php else: ?>
                    Add Sub-Category
                <?php endif; ?>
            </button>
        </div>
    </div>
    <div class="col-md-12 spacer"> 
        <div class="row userGridRowHeader">
            <div class="col-md-3 userGridColHeader" >Sub-Category</div>
            <div class="col-md-3 userGridColHeader" >Category</div>
            <div class="col-md-3 userGridColHeader" ></div>
            <div class="col-md-3 userGridColHeader" ></div>


        </div>
        <?php if(count($result) == 0): ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem">No sub-categories found...</div>                
            </div>
        <?php else: ?>
            <?php foreach($result as $category): ?>

                <div class="row altBG">
                    <div class="col-md-3 userGridColItem"><?php echo e($category->subcategory_name); ?></div>
                    <div class="col-md-3 userGridColItem"><?php echo e($category->category_name); ?></div>
                    <div class="col-md-3 userGridColItem"><a href="/admin/subcategory/edit/<?php echo e($category->id); ?>">Edit</a></div>
                    <div class="col-md-2 userGridColItem"><a href="#" data-href="/admin/subcategory/delete/<?php echo e($category->id); ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a></div>
                </div>
            <?php endforeach; ?>  
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo e(Form::open(['url' => env('APP_URL').'/admin/subcategory/add'])); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Sub-Category</h4>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo e(Form::select('cat_name',$categories,NULL,['id'=> 'rootCategory', 'class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Category'])); ?>

                    </div>
                </div>
                <?php if($level == 3): ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::select('sub_cat_name',$sub_categories,NULL,['id'=> 'subCategory','class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Sub-Category'])); ?>

                    </div>
                </div>
                <?php endif; ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::text('subcat_name',NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Enter Sub Category Name'])); ?>

                    </div>
                </div>
                <?php if($level == 3): ?>
                <div class="row spacer">
                    <div class="col-md-12">
                        <?php echo e(Form::select('courses[]',$courses,NULL,['class'=>'form-control col-md-4','maxlength'=>'80','tabindex'=>1,'placeholder'=>'Choose Courses ( CTRL + Mouse Click)','multiple'=>true,'size'=>15])); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="modal-footer text-right">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo e(Form::submit('Add Sub-Category',['class'=>'btn btn-primary btn-md col-md-4 text-right','tabindex'=>3])); ?>

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
                Are you sure you want to delete this sub-category?
            </div>
            <div class="modal-body">
                By deleting this sub-category, you will be deleting the connection to any courses underneath it. This will not delete the courses.
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

        $(document).ready(function($){
            $('#rootCategory').change(function(){
                $.get("<?php echo e(url('categories')); ?>",
                    { option: $(this).val() },
                    function(data) {
                        $('#subCategory').empty();
                        $.each(data, function(key, element) {
                            $('#subCategory').append("<option value='" + key +"'>" + element + "</option>");
                        });
                    });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>