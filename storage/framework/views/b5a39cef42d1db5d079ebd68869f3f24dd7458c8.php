<?php $__env->startSection('content'); ?>

   
    <div class="row">
        <div class="col-md-12" style="">
            <h3 class="ecomm_pageTitle">FAQs</h3>

            <!-- Data -->
            <div class="alert alert-warning">
                To quickly find a specific word or phrase on this page, use the "Find on this Page" tool. First, select
                "Edit" from the tool bar and choose "Find on this page..." In the box that opens, type the word or phrase
                you are looking for. Hit the enter key to be taken to any highlighted matches.
            </div>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <?php foreach($faqs as $faq): ?>
   
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading_<?php echo e($faq->unique_key); ?>">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo e($faq->unique_key); ?>" aria-expanded="true" aria-controls="collapseOne">
              <?php echo $faq->question; ?>

            </a>
          </h4>
        </div>
        <div id="collapse_<?php echo e($faq->unique_key); ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_<?php echo e($faq->unique_key); ?>">
          <div class="panel-body">
             <?php echo $faq->answer; ?>

          </div>
        </div>
          <?php if(!empty($faq->tags)): ?>
              <div>
                  <?php foreach($faq->tags as $maven_tag): ?>
                      <a href="?tag=<?php echo e(urlencode($maven_tag)); ?>" class="btn btn-xs btn-default"><?php echo e($maven_tag); ?></a>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>
      </div>
  <?php endforeach; ?>

</div>



<!-- Pager -->

<?php echo $faqs->links(); ?>

            
        </div>
    </div>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );
    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>