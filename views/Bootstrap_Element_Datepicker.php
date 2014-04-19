<div class="form-group">
    <?php echo $element->label();?>
    <div>
        <div class="input-group">
            <?php echo Form::input($element->attributes('name'), $element->attributes('value'), $element->attributes()); ?>
            <label for="<?php echo $element->attributes('id');?>" class="input-group-addon btn">
                <span class="glyphicon glyphicon-calendar"></span>
            </label>
        </div>
    </div>
    <?php echo $element->help_block();?>
</div>