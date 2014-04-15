<?php echo Form::open($element->attributes('action'), $element->attributes()); ?>
    <?php echo $element->content(); ?>
<?php echo Form::close(); ?>