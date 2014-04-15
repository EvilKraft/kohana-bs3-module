<div class="form-group">
    <?php if(isset($label)){ echo $label; }?>
    <?php echo $element->content(); ?>
    <?php if( isset($help_text)) echo $help_text; ?>
</div>