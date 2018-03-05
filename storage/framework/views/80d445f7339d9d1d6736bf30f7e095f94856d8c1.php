<?php $__env->startSection('content'); ?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            <h3>Buy One Get One</h3>
            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row well" style="padding-top:10px;margin-left:0px;margin-right:0px;">
        <div class="col-md-12">
            <h4>Offers Created</h4>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Course Name</th>
                <th>Offered Course</th>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($bogos as $key => $offer): ?>
            <tr>
                <td><?php echo e($offer['course']); ?></td>
                <td><?php echo e($offer['offer']); ?></td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                <?php echo e(Form::open(array('url' => 'bogo/' . $offer['id'], 'class' => 'pull-middle'))); ?>

                <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                <?php echo e(Form::submit('Delete', array('class' => 'btn btn-warning'))); ?>

                <?php echo e(Form::close()); ?>




                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>


    </div>
    <div class="loading" id="loading" style="display:none;"></div>
    <div class="loading-text" id="loading-text" style="display:none;">
        <div><h3>Please wait while we process your order.</h3></div>
    </div>
    <div class="loading-img" id="loading-img" style="display:none;text-align: center;">
        <img src="/images/ajax-loader.gif">
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>