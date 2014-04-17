<div class="form-group">
    <?php echo $element->label();?>
    <?php echo Form::input($element->attributes('name'), $element->attributes('value'), $element->attributes()); ?>
    <?php echo $element->help_block();?>
</div>