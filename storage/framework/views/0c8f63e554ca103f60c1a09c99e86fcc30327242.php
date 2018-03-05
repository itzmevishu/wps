<?php $__env->startSection('content'); ?>

    <div class="row" style="padding-top:25px;">
        <div class="col-md-12">
            <?php if(! empty(Session::get('errormsg'))): ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('errormsg')); ?>

                </div>
            <?php endif; ?>
            <?php if(! empty(Session::get('successMsg'))): ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(Session::get('successMsg')); ?>

                </div>
            <?php endif; ?>



        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="">
            <h3 class="ecomm_pageTitle">Admin Home</h3>
            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-4">
                    <a href="/admin/photos" style="text-decoration: none;">
                        <div class="dashboard_box">

                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-picture"></i>
                            </div>
                            Photos
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">Add a new course photo</div>

                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/admin/promos?tab=all" style="text-decoration: none;">
                        <div class="dashboard_box">
                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-gift"></i>
                            </div>
                            Promos
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">Add and Edit promos</div>
                        </div>
                    </a>

                </div>

                <div class="col-md-4" style="">
                    <a href="/admin/catalog" style="text-decoration: none;">
                        <div class="dashboard_box">
                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-transfer"></i>
                            </div>
                            Catalog
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">update product catalog</div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">

            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-4">
                    <a href="/admin/users" style="text-decoration: none;">
                        <div class="dashboard_box">
                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-user
glyphicon "></i>
                            </div>
                            Accounts
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">View and impersonate customers</div>
                        </div>
                    </a>

                </div>
                <div class="col-md-4">
                    <a href="/admin/reports" style="text-decoration: none;">
                        <div class="dashboard_box">
                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-download-alt"></i>
                            </div>
                            Reporting
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">Data Dump by date</div>
                        </div>
                    </a>

                </div>
                <div class="col-md-4">
                    <a href="/admin/category/home" style="text-decoration: none;">
                        <div class="dashboard_box">
                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-question-sign"></i>
                            </div>
                            Categories
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">Category & Subcategory</div>
                        </div>
                    </a>

                </div>
                

            </div>
        </div>

    </div>
    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">

            <div class="row ecomm_pageTitleWrapper">
                <div class="col-md-4">
                    <a href="/admin/faqs" style="text-decoration: none;">
                        <div class="dashboard_box">
                            <div class="pull-right green_icon">
                                <i class="glyphicon glyphicon-question-sign"></i>
                            </div>
                            FAQs
                            <div class="white_progress">

                                <div class="white_progress_inner" style="width:100%;"></div>

                            </div>
                            <div class="dashboard-box-footer">FAQ Mangement</div>
                        </div>
                    </a>

                </div>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $( "div.rowVC:even" ).css( "background-color", "#dbe5eb" );
    </script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>