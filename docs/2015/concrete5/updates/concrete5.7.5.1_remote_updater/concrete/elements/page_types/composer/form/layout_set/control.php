<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="ccm-page-type-composer-form-layout-control-set-control" data-page-type-composer-form-layout-control-set-control-id="<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>">
<div class="ccm-page-type-composer-item-control-bar">
	<ul class="ccm-page-type-composer-item-controls">
		<li><a href="#" data-command="move-set-control" style="cursor: move"><i class="fa fa-arrows"></i></a></li>
		<li><a data-command="edit-form-set-control" href="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/page_types/composer/form/edit_control?ptComposerFormLayoutSetControlID=<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>" class="dialog-launch" dialog-width="400" dialog-height="auto" dialog-modal="true" dialog-title="<?php echo t('Edit Form Control')?>"><i class="fa fa-pencil"></i></a></li>
		<li><a href="#" data-delete-set-control="<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>"><i class="fa fa-trash-o"></i></a></li>
	</ul>

	<div style="display: none">
		<div data-delete-set-control-dialog="<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>">
			<?php echo t("Delete this control? This cannot be undone.")?>
			<?php echo Loader::helper('validation/token')->output('delete_set_control')?>

            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="Composer.deleteFromLayoutSetControl(<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>)"><?php echo t('Update Set')?></button>
            </div>

		</div>
	</div>

<div class="ccm-page-type-composer-form-layout-control-set-control-inner">
	<?php
	print $control->getPageTypeComposerControlDisplayLabel();
	?>
</div>
</div>
</div>
