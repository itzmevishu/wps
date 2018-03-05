<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    <a href="/admin">Return to Admin</a>
    <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Session::get('success'); ?>

        </div>
    <?php endif; ?>
     <div class="col-md-12 spacer">
         <div class="row">
            <div class="col-md-8" style="padding-left:0px;">
                <h3>Product Catalog</h3>
            </div>
            <div class="col-md-4 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <a href="/admin/catalog/update" class="btn btn-primary" style="margin: 0px;">Update Catalog</a>
            </div>
        </div>   
    </div>   
    <div class="col-md-12 spacer">

        <div class="row userGridRowHeader">
            <div class="col-md-2 userGridColHeader" >Reference Code</div>
            <div class="col-md-2 userGridColHeader" >Title</div>
            <div class="col-md-2 userGridColHeader" >Key Words</div>
            <div class="col-md-2 userGridColHeader" >Price</div>
            <div class="col-md-1 userGridColHeader" >Upload Code</div>
            <div class="col-md-1 userGridColHeader" >Active</div>
            <div class="col-md-1 userGridColHeader" >Last Update</div>

        </div>

        <?php foreach($products as $product): ?>
        <?php $imageName = str_replace('/', '', $product->image); ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem"><?php echo e($product->code); ?></div>
                <div class="col-md-2 userGridColItem"><?php echo e($product->name); ?> </div>
                <div class="col-md-2 userGridColItem" ><?php echo e($product->ecommerce_short_description); ?></div>
                <div class="col-md-2 userGridColItem" ><?php echo e('$' . number_format($product->price, 2)); ?></div>
                <div class="col-md-1 userGridColItem" ><?php echo e($imageName); ?> <?php if(!file_exists(public_path().'/images/courses/'.$imageName.'.png')): ?><div style="padding-top:15px"><strong>Image Missing</strong></div><?php else: ?><div><img style="width:100px;" src='/images/courses/<?php echo e($imageName); ?>.png'}}></div><?php endif; ?></div>
                <div class="col-md-1 userGridColItem" ><?php echo e($product->active? 'Active': 'Inactive'); ?></div>
                <div class="col-md-1 userGridColItem" ><?php echo e($product->updated_at); ?></div>
                <div class="col-md-12 userGridColItem"><strong>Description</strong><br><?php echo e($product->description); ?></div>

                
            </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="col-md-8 text-left" style="padding-left: 0px;">
                <?php echo e($products->links()); ?>

            </div>
            
            <div class="col-md-4 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <a href="/admin/catalog/update" class="btn btn-primary" style="margin: 0px;">Update Catalog</a>
            </div>
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
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>