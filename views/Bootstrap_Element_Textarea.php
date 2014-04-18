<div class="form-group">
    <?php echo $element->label();?>
    <?php echo Form::textarea($element->attributes('name'), $element->text(), $element->attributes()); ?>
    <?php echo $element->help_block();?>
</div>