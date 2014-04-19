<?php echo Form::open($element->attributes('action'), $element->attributes()); ?>
    <fieldset>
        <?php echo $element->caption();?>
        <?php
            foreach($element->children() as $child){
                echo $child;
            }
        ?>
    </fieldset>
<?php echo Form::close(); ?>