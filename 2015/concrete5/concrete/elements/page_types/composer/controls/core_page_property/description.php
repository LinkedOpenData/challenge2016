<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="form-group">
	<label class="control-label"><?php echo $label?></label>
	<?php if($description): ?>
	<i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php echo $description?>"></i>
	<?php endif; ?>
	<?php echo $form->textarea($this->field('description'), $control->getPageTypeComposerControlDraftValue(), array('style' => 'height: 100px'))?>
</div>
