<?php $__env->startSection('content'); ?>

    <div class="row well"  style="margin-top:25px;">
        <div class="col-md-12" style="padding-left:0px;">

             <p>
                <?php if(Auth::check()): ?>
                    <strong style="font-size:large">Welcome <?php echo e($userAuth->first_name); ?>!</strong>
                <?php else: ?>
                     <strong style="font-size:large">Welcome!</strong>
                <?php endif; ?>
            </p>

                <p>Welcome to the WPS Learning Center!</p>
            <?php if(Auth::check()): ?>
                <?php if(! empty(Session::get('freeFAM'))): ?>
                    <div class="alert alert-info" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Session::get('freeFAM'); ?>

                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row" style="background-color: #fff;padding-top: 5px;padding-bottom: 25px;padding-left: 25px;padding-right: 25px;">

        <div class="row">
            <div class="col-md-12">
                <h4>Available Courses</h4>
                <?php if($searchTerm != ''): ?><p style="font-style: italic;font-weight: bold">Searching for: <?php echo e($searchTerm); ?></p><?php endif; ?>
            </div>
        </div>


        <div class="row">
            
        <?php if(count($courses) == 0): ?>
        <div class="col-sm-3 spacer" style="padding-top:10px;">
        No courses found...
        </div>

        <?php else: ?>
            <?php foreach($courses as $course): ?>

                <div class="col-sm-3 spacer" style="border-bottom: 1px solid #ccc;padding-top:10px;">
                    <div style="position: relative">
                        <a href="/confirm-course?courseid=<?php echo e($course['course_id']); ?>" style="text-decoration:none;">
                        <?php if($course['price'] == 0): ?>
                            <div><div class="ribbon-wrapper-green"><div class="ribbon-green">FREE</div></div><img src="<?php echo e($image_file); ?>" style="width:100%"></div>
                        <?php else: ?>
                            <div><img src="<?php echo e($course['image']); ?>" style="width:258px;height:258px;"></div>
                        <?php endif; ?>

                        <div style="min-height:60px;"><h4><?php echo e($course['name']); ?></h4></div>
                        </a>
                        <div style="min-height:50px;left: 15px;right: 15px;">
                        <a href="/confirm-course?courseid=<?php echo e($course['course_id']); ?>" class="btn btn-primary pull-left">View Details</a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
            
        </div>
    </div>
<?php echo e($courses->appends(['search_terms' => $searchTerm])->links()); ?>





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