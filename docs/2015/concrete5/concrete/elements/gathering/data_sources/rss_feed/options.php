<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
if (is_object($configuration)) { 
	$rssFeedURL = $configuration->getRSSFeedURL();
}
?>
<div class="control-group">
	<label class="control-label"><?php echo t('RSS Feed')?></label>
	<div class="controls">
		<?php echo $form->text($source->optionFormKey('rssFeedURL'), $rssFeedURL)?>
	</div>
</div>
