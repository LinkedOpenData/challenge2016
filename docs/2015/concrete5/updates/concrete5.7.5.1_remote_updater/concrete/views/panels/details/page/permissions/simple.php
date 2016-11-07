<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<section class="ccm-ui">
	<header><?php echo t('Page Permissions')?></header>
	<form method="post" action="<?php echo $controller->action('save_simple')?>" data-dialog-form="permissions" data-panel-detail-form="permissions">
		<?php echo Loader::helper('concrete/ui/help')->display('panel', '/page/permissions')?>
		
		<p class="lead"><?php echo t('Who can view this page?')?></p>



		<?php

		foreach ($gArray as $g) {
		?>

		<div class="radio"><label><input type="checkbox" name="readGID[]" value="<?php echo $g->getGroupID()?>" <?php if (in_array($g->getGroupID(), $viewAccess)) { ?> checked <?php } ?> /> <?php echo $g->getGroupDisplayName(false)?></label></div>

		<?php } ?>

		<hr/>

		<p class="lead"><?php echo t('Who can edit this page?')?></p>

		<?php

		foreach ($gArray as $g) {
		?>

		<div class="radio"><label><input type="checkbox" name="editGID[]" value="<?php echo $g->getGroupID()?>" <?php if (in_array($g->getGroupID(), $editAccess)) { ?> checked <?php } ?> /> <?php echo $g->getGroupDisplayName(false)?></label></div>

		<?php } ?>

	</form>
	<div class="dialog-buttons ccm-panel-detail-form-actions">
		<button class="pull-left btn btn-default" type="button" data-dialog-action="cancel" data-panel-detail-action="cancel"><?php echo t('Cancel')?></button>
		<button class="pull-right btn btn-success" type="button" data-dialog-action="submit" data-panel-detail-action="submit"><?php echo t('Save Changes')?></button>
	</div>
</section>