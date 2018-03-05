<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">

                <?php if($message = Session::get('success')): ?>

                <div class="custom-alerts alert alert-success fade in">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                    <?php echo $message; ?>


                </div>

                <?php Session::forget('success');?>

                <?php endif; ?>

                <?php if($message = Session::get('error')): ?>

                <div class="custom-alerts alert alert-danger fade in">

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                    <?php echo $message; ?>


                </div>

                <?php Session::forget('error');?>

                <?php endif; ?>

                <div class="panel-heading">Paywith Paypal</div>

                <div class="panel-body">

                    <form class="form-horizontal" method="POST" id="payment-form" role="form" action="<?php echo URL::route('addmoney.paypal'); ?>" >

                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">

                            <label for="amount" class="col-md-4 control-label">Amount</label>

                            <div class="col-md-6">

                                <input id="amount" type="text" class="form-control" name="amount" value="<?php echo e(old('amount')); ?>" autofocus>

                                <?php if($errors->has('amount')): ?>

                                    <span class="help-block">

                                        <strong><?php echo e($errors->first('amount')); ?></strong>

                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                        

                        <div class="form-group">

                            <div class="col-md-6 col-md-offset-4">

                                <button type="submit" class="btn btn-primary">

                                    Paywith Paypal

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>