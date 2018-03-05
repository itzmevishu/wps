<?php $__env->startSection('content'); ?>

<div class="row" style="padding-top:25px;">
    <a href="/admin">Return to Admin</a>
    <h3>Altec Store Accounts</h3>

    <div class="row spacer ">
        <div class="col-md-6 text-left">

        </div>
        <?php echo e(Form::open(['url' =>env('APP_URL').'/admin/users/search'])); ?>

        <div class="col-md-4 text-right">

            <?php echo e(Form::text('user_search','',['class'=>'form-control col-md-4','autocomplete'=>'off','tabindex'=>1,'placeholder'=>'Search by Username or email...'])); ?>

            <div class="errors"><?php echo e($errors->first('user_search')); ?></div>
        </div>
        <div class="col-md-2 text-right">
            <?php echo e(Form::submit('Search Accounts',['class'=>'btn btn-primary','style'=>"margin-right:0px;"])); ?>


        </div>
        <?php echo e(Form::close()); ?>

    </div>
    <div class="col-md-12">
        <div class="row userGridRowHeader">
            <div class="col-md-2 userGridColHeader" >Name</div>
            <div class="col-md-3 userGridColHeader" >Username</div>
            <div class="col-md-3 userGridColHeader" >Company</div>
            <div class="col-md-1 userGridColHeader" >&nbsp;</div>
            <div class="col-md-2 userGridColHeader" >&nbsp;</div>
            <div class="col-md-1 userGridColHeader" >&nbsp;</div>

        </div>

        <?php foreach($users as $user): ?>
            <div class="row altBG">
                <div class="col-md-2 userGridColItem"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></div>
                <div class="col-md-3 userGridColItem"><?php echo e($user->username); ?></div>
                <div class="col-md-3 userGridColItem"><?php echo e($user->company_name); ?></div>
                <div class="col-md-2 userGridColItem"><a href="/users/<?php echo e($user->id); ?>/impersonate">impersonate</a></div>
                <div class="col-md-2 userGridColItem"><?php if($user->site_admin): ?> <a href="/users/remove-admin/<?php echo e($user->id); ?>">remove admin</a> <?php else: ?><a href="/users/make-admin/<?php echo e($user->id); ?>">make admin</a><?php endif; ?></div>
            </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="col-md-6 text-left" style="padding-left: 0px;">
                <?php echo e($users->links()); ?>

            </div>
            <div class="col-md-6 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <?php if($search == 'yes'): ?>
                    <a href="/admin/users" class="btn btn-secondary" style="margin: 0px;">Show All</a>
                <?php endif; ?>

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