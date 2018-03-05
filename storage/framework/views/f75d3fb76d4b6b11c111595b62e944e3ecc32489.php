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
            <!--
            <div class="col-md-2 userGridColHeader" >Key Words</div>
            -->
            <div class="col-md-1 userGridColHeader" >Price</div>
            <div class="col-md-2 userGridColHeader" >Image</div>
            <div class="col-md-1 userGridColHeader" >Active</div>
            <div class="col-md-1 userGridColHeader" >BOGO</div>
            <div class="col-md-2 userGridColHeader" >Last Update</div>
        </div>

        <?php foreach($products as $product): ?>
        <?php //$imageName = str_replace('/', '', $product->image); ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem"><?php echo e($product->code); ?></div>
                <div class="col-md-2 userGridColItem"><?php echo e($product->name); ?> </div>
               <!--
                <div class="col-md-2 userGridColItem" ><?php echo e($product->ecommerce_short_description); ?></div>
                -->
                <div class="col-md-1 userGridColItem" ><?php echo e('$' . number_format($product->price, 2)); ?></div>
                <div class="col-md-2 userGridColItem" ><div>
                        <?php echo e(\Html::tag('a', \Html::image($product->image ."?v=".time(), 'Course Image', array('style' => 'width:100px;'))->toHtml(), ['href' => '/admin/photos/'.$product->id])); ?>

                    </div></div>
                <div class="col-md-1 userGridColItem" ><?php echo e($product->active? 'Active': 'Inactive'); ?></div>
                <div class="col-md-1 userGridColItem" >
                    <a href="#" data-rel="<?php echo e($product->name); ?>" class="bogo">
                        <i class="fa fa-check" style="font-size:24px;color:green;"></i>
                    </a>
                </div>
                <div class="col-md-2 userGridColItem " ><?php echo e(date('Y-m-d',strtotime($product->updated_at))); ?></div>

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

            $('.bogo').on('click', function(e) {
                e.preventDefault();
                alert("Activating BOGO Feature for "+$(this).attr('data-rel'));
            });
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>