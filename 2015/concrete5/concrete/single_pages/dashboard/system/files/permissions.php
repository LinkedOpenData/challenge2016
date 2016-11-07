<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

	<?php ob_start(); ?>
	<?php echo Loader::element('permission/help');?>
	<?php $help = ob_get_contents(); ?>
	<?php ob_end_clean(); ?>
	<?php $fs = FileSet::getGlobal(); ?>
		<form method="post" action="<?php echo $view->action('save')?>" id="ccm-permission-list-form">
	
	<?php echo Loader::helper('validation/token')->output('save_permissions')?>
	<div class="ccm-pane-body">
	<?php
	$tp = new TaskPermission();
	if ($tp->canAccessTaskPermissions()) { ?>	
		<?php Loader::element('permission/lists/file_set', array('fs' => $fs))?>
	<?php } else { ?>
		<p><?php echo t('You cannot access task permissions.')?></p>
	<?php } ?>
	</div>
	<div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?php echo $view->url('/dashboard/system/files/permissions')?>" class="btn btn-default pull-left"><?php echo t('Cancel')?></a>
            <button class="pull-right btn btn-primary" type="submit" ><?php echo t('Save')?></button>
        </div>
    </div>
	</form>
