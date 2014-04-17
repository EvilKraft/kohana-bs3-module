<?php echo Form::open($element->attributes('action'), $element->attributes()); ?>
    <?php
        foreach($element->children() as $child){
            echo $child;
        }
    ?>
<?php echo Form::close(); ?>