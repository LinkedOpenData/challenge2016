<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="control-group">
	<label class="control-label"><?php echo $label?></label>
	<?php if($description): ?>
	<i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php echo $description?>"></i>
	<?php endif; ?>
	<div class="controls">
		<?php
		print Core::make('editor')->outputPageComposerEditor($view->field('content'), $controller->getContentEditMode());
		?>
	</div>
</div>