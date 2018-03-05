<!DOCTYPE html>
<html lang="<?php echo e(\App::getLocale()); ?>">
<head>
    <title><?php echo e(trans('maven::manage.title')); ?></title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style>

        .text-bold {

            font-weight:bold;

        }

        .line-height-2 {

            line-height: 2em !important;

        }

    </style>
</head>
<body>
<div class="container">

    <?php if(!empty($message)): ?>
    <br>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $message; ?>

    </div>
    <?php else: ?>
    <br>
    <?php endif; ?>
    <div class="text-right">
        <a href="/maven" class="btn btn-default btn-sm"><?php echo e(trans('maven::manage.clear')); ?></a>
        <button id="add_button" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> <?php echo e(trans('maven::manage.add')); ?></button>
    </div>
    <?php if(Request::has('remove_id') || (!Request::has('_token') && !Request::has('id'))): ?>
        <?php echo Form::open(['id' => 'save_form', 'style' => 'display:none']); ?>

    <?php else: ?>
        <?php echo Form::open(['id' => 'save_form']); ?>

    <?php endif; ?>
    <br>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="pull-right">
                <a href="/maven"><i class="glyphicon glyphicon-remove-sign" style="color:#fff;"></i></a>
            </div>
            <h3 class="panel-title text-bold"><i class="glyphicon glyphicon-question-sign"></i> <?php echo e(trans('maven::manage.faq_form')); ?></h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <i class="glyphicon glyphicon-chevron-right"></i> <?php echo Form::label(trans('maven::manage.question')); ?><br>
                <?php echo Form::text('question', Request::get('question'), ['class' => 'form-control']); ?>

            </div>
            <div class="form-group">
                <i class="glyphicon glyphicon-chevron-right"></i> <?php echo Form::label(trans('maven::manage.answer')); ?><br>
                <?php echo Form::textarea('answer', Request::get('answer'), ['rows' => 5, 'class' => 'form-control']); ?>

            </div>
            <div class="form-group">
                <i class="glyphicon glyphicon-chevron-right"></i> <?php echo Form::label(trans('maven::manage.sort')); ?><br>
                <?php echo Form::select('sort', $sort_values, Request::get('sort')); ?>

            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <i class="glyphicon glyphicon-chevron-right"></i> <?php echo Form::label(trans('maven::manage.tags')); ?><br>
                    <?php echo Form::text('tags', Request::get('tags'), ['id' => 'tags', 'class' => 'form-control']); ?>

                    <br><span class="text-muted"><?php echo e(trans('maven::manage.tag_e_g')); ?></span>
                </div>
                <div class="form-group col-md-6">
                    <br>
                    <div>
                    <?php if(count($tag_values) > 0): ?>
                        <?php foreach($tag_values as $tag_value): ?>
                            <a href="#" class="label label-info tags"><?php echo e($tag_value); ?></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <i class="glyphicon glyphicon-chevron-right"></i> <?php echo Form::label(trans('maven::manage.locale')); ?><br>
                <?php echo Form::select('locale', \Sukohi\Maven\MavenLocale::options(), Request::get('locale')); ?>

                </div>
            </div>
            <div class="clearfix form-group checkbox">
                <label><?php echo Form::checkbox('draft_flag', '1', Request::get('draft_flag')); ?> <?php echo e(trans('maven::manage.save_as_draft')); ?></label>
            </div>
            <div class="text-right">
                <?php echo link_to(URL::current() .'?locale='. Request::get('locale'), trans('maven::manage.cancel'), ['class' => 'btn btn-md btn-default']); ?>&nbsp;
                <button type="submit" class="btn btn-md btn-primary"><i class="glyphicon glyphicon-saved"></i> <?php echo e(trans('maven::manage.save')); ?></button>
            </div>
        </div>
    </div>
    <?php if(Request::has('id')): ?>
        <?php echo Form::hidden('id', Request::get('id')); ?>

    <?php endif; ?>
    <?php if(Request::has('search_locale')): ?>
        <?php echo Form::hidden('search_locale', Request::get('search_locale')); ?>

    <?php endif; ?>
    <br>
    <?php echo Form::close(); ?>

    <?php if(!empty($locales)): ?>
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <?php echo e(trans('maven::manage.locale')); ?>

                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="?search_locale="><?php echo e(trans('maven::manage.all')); ?></a></li>
                <?php foreach($locales as $locale): ?>
                    <li><a href="?search_locale=<?php echo e($locale); ?>"><?php echo e($locale); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <br>
    <?php else: ?>
        <br>
        <br>
    <?php endif; ?>
    <?php if($faqs->count() > 0): ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><nobr><?php echo e(trans('maven::manage.q_and_a')); ?></nobr></th>
                    <th><nobr><?php echo e(trans('maven::manage.tags')); ?></nobr></th>
                    <th><nobr><?php echo e(trans('maven::manage.locale')); ?></nobr></th>
                    <th><nobr><?php echo e(trans('maven::manage.unique_key')); ?></nobr></th>
                    <th class="text-center"><nobr><?php echo e(trans('maven::manage.draft')); ?></nobr></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($faqs as $index => $faq): ?>
                <tr>
                    <td><?php echo $faq->sort_number; ?></td>
                    <td>
                        <div class="text-bold"><?php echo $faq->question; ?></div>
                        <br>
                        <?php echo $faq->answer; ?>

                    </td>
                    <td class="line-height-2">
                        <?php if(!empty($faq->tags)): ?>
                            <?php foreach($faq->tags as $tag): ?>
                                <?php if(!empty($tag)): ?>
                                <a href="?locale=<?php echo e(Request::get('locale')); ?>&search_key=<?php echo e(urlencode($tag)); ?>" class="btn btn-default btn-xs"><?php echo e($tag); ?></a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td class="line-height-2">
                        <?php if(!empty($faq->locale)): ?>
                        <a class="btn btn-default btn-xs" href="?search_locale=<?php echo e($faq->locale); ?>"><?php echo $faq->locale; ?></a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $faq->unique_key; ?></td>
                    <td class="text-center"><?php echo $faq->draft_flag_icon; ?></td>
                    <td class="text-right">
                        <nobr>
                        &nbsp;
                        &nbsp;
                        <a href="?id=<?php echo e($faq->id); ?>&search_locale=<?php echo e(Request::get('locale')); ?>" class="btn btn-xs btn-default btn-warning">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </a>
                        <button href="?id=<?php echo e($faq->id); ?>" class="btn btn-xs btn-default btn-danger remove-button" data-id="<?php echo e($faq->id); ?>">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                        </nobr>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center">
            <?php echo $faqs->render(); ?>

        </div>
    <?php endif; ?>
    <?php echo Form::open(['id' => 'remove_form']); ?>

        <?php echo Form::hidden('remove_id', '', ['id' => 'remove_id']); ?>

    <?php echo Form::close(); ?>

</div>
<script>
    $(document).ready(function(){

        $('#add_button').on('click', function(){

            $('#save_form').slideToggle('fast');
            $('textarea[name=question]').focus();

        });
        $('.remove-button').on('click', function(){

            if(confirm('Delete this record?')) {

                var id = $(this).data('id');
                $('#remove_id').val(id);
                $('#remove_form').submit();

            }

        });
        $('.tags').on('click', function(){

            var tag = $(this).html();
            var currentTagString = $('#tags').val();
            var currentTags = currentTagString.split(',');

            if($.inArray(tag, currentTags) == -1) {

                var newTagString = currentTagString;

                if(currentTagString != '') {

                    newTagString += ',';

                }

                newTagString += tag;
                $('#tags').val(newTagString)

            }

            return false;

        });

    });
</script>
</body>
</html>
