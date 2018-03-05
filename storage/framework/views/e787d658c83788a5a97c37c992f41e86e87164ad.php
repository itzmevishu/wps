<?php $__env->startSection('content'); ?>

    
    <div class="row" style="margin-top:25px;background-color: #fff;padding-top: 5px;padding-bottom: 25px;padding-left: 25px;padding-right: 25px;">

        <div class="row">
            <div class="col-md-12">
                <?php if(isset($free)): ?>
                    <h4>Available Free Courses</h4>
                <?php else: ?>
                    <h4>Courses Available in <?php echo e($parentName); ?> / <?php echo e($childName); ?></h4>
                <?php endif; ?>
                
            </div>
        </div>


        <div class="row">
        <?php if(count($courses)>0): ?>
            <?php foreach($courses as $course): ?>
            <?php $imageName = str_replace('/', '', $course['image']); ?>
                
                <div class="col-sm-3 spacer" style="border-bottom: 1px solid #ccc;padding-top:10px;">
                    <div style="position: relative">
                        <a href="/confirm-course?courseid=<?php echo e($course['course_id']); ?>" style="text-decoration:none;">
                        <?php if($course['price'] == 0): ?>
                            <div><div class="ribbon-wrapper-green"><div class="ribbon-green">FREE</div></div><img src="/images/courses/<?php echo e($imageName); ?>.png" style="width:100%"></div>
                        <?php else: ?>
                            <div><img src="/images/courses/<?php echo e($imageName); ?>.png" style="width:100%"></div>
                        <?php endif; ?>

                        <div style="min-height:60px;"><h4><?php echo e($course['name']); ?></h4></div>
                        </a>
                        <div style="min-height:50px;left: 15px;right: 15px;">
                        <a href="/confirm-course?courseid=<?php echo e($course['course_id']); ?>" class="btn btn-primary pull-left">View Details</a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-sm-3">
                    <div style="position: relative">
                        No Courses found...
                    </div>
                </div>
        <?php endif; ?>
            
        </div>
    </div>
<?php echo e($courses->links()); ?>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

    <script>
        $('.collapse').on('shown.bs.collapse', function(){
            $(this).parent().find(".glyphicon-chevron-right").removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-down");
        }).on('hidden.bs.collapse', function(){
            $(this).parent().find(".glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-right");
        });

    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>