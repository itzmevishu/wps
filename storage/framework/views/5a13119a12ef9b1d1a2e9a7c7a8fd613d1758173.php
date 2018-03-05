<?php
    use App\Models\PromoCourse;
    use App\Models\Catalog;
?>


<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    <a href="/admin">Return to Admin</a>
    <h3>Promo Codes</h3>
    <div class="row spacer ">
        <div class="col-md-6 text-left">
            <ul class="nav nav-pills">
                <li role="presentation" <?php if(isset($input['tab']) && $input['tab'] == 'all'): ?> class="active" <?php endif; ?>><a href="/admin/promos?page=1&tab=all">All</a></li>
                <li role="presentation" <?php if(isset($input['tab']) && $input['tab'] == 'active'): ?> class="active" <?php endif; ?>><a href="/admin/promos?page=1&tab=active">Active</a></li>
                <li role="presentation" <?php if(isset($input['tab']) && $input['tab'] == 'inactive'): ?> class="active" <?php endif; ?>><a href="/admin/promos?page=1&tab=inactive">Inactive</a></li>
            </ul>
        </div>
        <div class="col-md-6 text-right">
            <?php echo e(Form::open(['url' =>env('APP_URL').'/admin/promos/search?tab=all'])); ?>

            <div class="col-md-8 text-right">

                <?php echo e(Form::text('promo_search','',['class'=>'form-control col-md-4','autocomplete'=>'off','tabindex'=>1,'placeholder'=>'Search by Promo Code...'])); ?>

                <div class="errors"><?php echo e($errors->first('promo_search')); ?></div>
            </div>
            <div class="col-md-4 text-right" style="padding-right:0px;">
                <?php echo e(Form::submit('Search Promos',['class'=>'btn btn-primary','style'=>"margin-right:0px;"])); ?>


            </div>
            <?php echo e(Form::close()); ?>

        </div>

    </div>

    <div class="col-md-12 spacer">

        <div class="row userGridRowHeader">
            <div class="col-md-2 userGridColHeader" >Promo Code</div>
            <div class="col-md-2 userGridColHeader" >Description</div>
            <div class="col-md-2 userGridColHeader" >Start Date</div>
            <div class="col-md-2 userGridColHeader" >End Date</div>
            <div class="col-md-1 userGridColHeader" >Stackable</div>
            <div class="col-md-1 userGridColHeader" >Use</div>
            <div class="col-md-1 userGridColHeader" >&nbsp;</div>

        </div>

        <?php foreach($promos as $promo): ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem"><?php echo e($promo->promo_code); ?></div>
                <div class="col-md-2 userGridColItem"><?php echo e($promo->promo_desc); ?> <?php echo e($promo->promo_apply_to); ?></div>
                <?php if($promo->promo_no_expiry): ?>
                    <div class="col-md-2 userGridColItem"><?php echo e($promo->promo_start_dt); ?></div>
                    <div class="col-md-2 userGridColItem">-</div>
                <?php else: ?>
                    <div class="col-md-2 userGridColItem"><?php echo e($promo->promo_start_dt); ?></div>
                    <div class="col-md-2 userGridColItem"><?php echo e($promo->promo_end_dt); ?></div>
                <?php endif; ?>
                <?php if($promo->promo_stackable): ?>
                    <div class="col-md-1 userGridColItem">Yes</div>
                <?php else: ?>
                    <div class="col-md-1 userGridColItem">No</div>
                <?php endif; ?>
                <?php if($promo->promo_single_use): ?>
                    <div class="col-md-1 userGridColItem">Once</div>
                <?php else: ?>
                    <div class="col-md-1 userGridColItem">No Limit</div>
                <?php endif; ?>

                <?php if($promo->promo_enable): ?>
                    <div class="col-md-1 userGridColItem"><a href="/admin/promos/disable/<?php echo e($promo->id); ?>">disable</a></div>
                <?php else: ?>
                    <div class="col-md-1 userGridColItem"><a href="/admin/promos/enable/<?php echo e($promo->id); ?>">enable</a></div>
                <?php endif; ?>

                    <div class="col-md-1 userGridColItem"><a href="/admin/promos/delete/<?php echo e($promo->id); ?>">delete</a></div>
                    <?php
                        $getPromoCount = DB::table('ecomm_promo_used')->where('promo_id',$promo->id)->count();

                    ?>
                    <div class="col-md-12" style="padding-bottom: 5px;font-style: italic;">
                    This promo has been used <strong><?php echo e($getPromoCount); ?></strong> times.
                    </div>
                <?php if($promo->promo_type_id == 2 || $promo->promo_type_id == 3): ?>
                    <?php
                        $getCourses = DB::table('ecomm_catalog')->select('lms_title')->join('ecomm_promo_course_LU','lms_course_id','=','course_id')->where('promo_id',$promo->id)->get();

                    ?>

                <div class="col-md-12" style="padding-bottom: 5px;font-style: italic;">
                    Courses <?php if($promo->promo_all_products_req): ?> (All required) <?php endif; ?> <?php if(!$promo->promo_all_products_req): ?> (At least ONE required) <?php endif; ?>:
                    <?php foreach($getCourses as $course): ?>
                        / <?php echo e($course->lms_title); ?> &nbsp;&nbsp;
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if($promo->promo_fam): ?>
                <div class="col-md-12" style="padding-bottom: 5px;font-style: italic;">
                    Free FAM Course: Free course eligible to Learners w/ serial# & Activation Code
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="col-md-8 text-left" style="padding-left: 0px;">
                <?php if(isset($input['tab'])): ?>
                    <?php echo e($promos->appends(['tab' => $input['tab']])->links()); ?>

                <?php else: ?>
                    <?php echo e($promos->appends(['tab' => 'active'])->links()); ?>

                <?php endif; ?>
            </div>
            <div class="col-md-2 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <?php if($search == 'yes'): ?>
                    <a href="/admin/users" class="btn btn-secondary" style="margin: 0px;">Show All</a>
                <?php endif; ?>
            </div>
            <div class="col-md-2 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <a href="/admin/promos/new" class="btn btn-primary" style="margin: 0px;">Add Promo</a>
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