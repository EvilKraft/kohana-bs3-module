<?php if($element->text() != ''): ?>
<span<?php echo HTML::attributes($element->attributes());?>><?php echo $element->text(); ?></span>
<?php endif; ?>