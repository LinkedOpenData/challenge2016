<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
use \Concrete\Core\Page\Type\Composer\FormLayoutSet as PageTypeComposerFormLayoutSet;
use \Concrete\Core\Page\Type\Composer\FormLayoutSetControl as PageTypeComposerFormLayoutSetControl;
use \Concrete\Core\Page\Type\Composer\Control\Type\Type as PageTypeComposerControlType;

$c = Page::getByPath('/dashboard/pages/types/form');
$cp = new Permissions($c);
$ih = Loader::helper('concrete/ui');
$control = PageTypeComposerFormLayoutSetControl::getByID($_REQUEST['ptComposerFormLayoutSetControlID']);
if (!is_object($control)) {
	die(t('Invalid control'));
}
$form = Loader::helper('form');

$object = $control->getPageTypeComposerControlObject();
$customTemplates = $object->getPageTypeComposerControlCustomTemplates();
$templates = array('' => t('** None'));
foreach($customTemplates as $template) {
	$templates[(string)$template->getPageTypeComposerControlCustomTemplateFilename()] = $template->getPageTypeComposerControlCustomTemplateName();
}

if ($cp->canViewPage()) { 

	if ($_POST['task'] == 'edit' && Loader::helper('validation/token')->validate('update_set_control')) {
		$sec = Loader::helper('security');
		$label = $sec->sanitizeString($_POST['ptComposerFormLayoutSetControlCustomLabel']);
		$template = $sec->sanitizeString($_POST['ptComposerFormLayoutSetControlCustomTemplate']);
		$description = $sec->sanitizeString($_POST['ptComposerFormLayoutSetControlDescription']);
		$required = $sec->sanitizeInt($_POST['ptComposerFormLayoutSetControlRequired']);
		$control->updateFormLayoutSetControlCustomLabel($label);
		$control->updateFormLayoutSetControlCustomTemplate($template);
		$control->updateFormLayoutSetControlDescription($description);
		if ($object->pageTypeComposerFormControlSupportsValidation()) {
			$control->updateFormLayoutSetControlRequired($required);
		}
		Loader::element('page_types/composer/form/layout_set/control', array('control' => $control));
		exit;
	}

	?>

	<div class="ccm-ui">
		<form data-edit-set-form-control="<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>" action="#" method="post">
		<div class="form-group">
			<?php echo $form->label('ptComposerFormLayoutSetControlCustomLabel', t('Custom Label'))?>
			<?php echo $form->text('ptComposerFormLayoutSetControlCustomLabel', $control->getPageTypeComposerFormLayoutSetControlCustomLabel())?>
		</div>
		<div class="form-group">
			<?php echo $form->label('ptComposerFormLayoutSetControlCustomTemplate', t('Custom Template'))?>
			<?php echo $form->select('ptComposerFormLayoutSetControlCustomTemplate', $templates, $control->getPageTypeComposerFormLayoutSetControlCustomTemplate())?>
		</div>
		<div class="form-group">
			<?php echo $form->label('ptComposerFormLayoutSetControlDescription', t('Description'))?>
			<?php echo $form->text('ptComposerFormLayoutSetControlDescription', $control->getPageTypeComposerFormLayoutSetControlDescription())?>
		</div>

		<?php if ($object->pageTypeComposerFormControlSupportsValidation()) { ?>
		<div class="form-group">
			<?php echo $form->label('ptComposerFormLayoutSetControlRequired', t('Required'))?>
			<div class="checkbox">
			<label><?php echo $form->checkbox('ptComposerFormLayoutSetControlRequired', 1, $control->isPageTypeComposerFormLayoutSetControlRequired())?> <?php echo t('Yes, require this form element')?></label>
			</div>
		</div>
		<?php } ?>

		<?php echo Loader::helper('validation/token')->output('update_set_control')?>
		</form>
		<div class="dialog-buttons">
			<button class="btn btn-default" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
			<button class="btn btn-primary pull-right" data-submit-set-form="<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>"><?php echo t('Save')?></button>
		</div>

	</div>


<script type="text/javascript">
$(function() {
	$('form[data-edit-set-form-control]').on('submit', function() {
		var ptComposerFormLayoutSetControlID = $(this).attr('data-edit-set-form-control');
		var formData = $('form[data-edit-set-form-control=' + ptComposerFormLayoutSetControlID + ']').serializeArray();
		formData.push({
			'name': 'ptComposerFormLayoutSetControlID',
			'value': ptComposerFormLayoutSetControlID
		}, {
			'name': 'task',
			'value': 'edit'
		});
		jQuery.fn.dialog.showLoader();
		$.ajax({
			type: 'post',
			data: formData,
			url: '<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/page_types/composer/form/edit_control',
			success: function(html) {
				jQuery.fn.dialog.hideLoader();
				jQuery.fn.dialog.closeTop();
				$('div[data-page-type-composer-form-layout-control-set-control-id=<?php echo $control->getPageTypeComposerFormLayoutSetControlID()?>]').html(html);
				$('a[data-command=edit-form-set-control]').dialog();
			}
		});		
		return false;
	});
	$('button[data-submit-set-form]').on('click', function() {
		var ptComposerFormLayoutSetControlID = $(this).attr('data-submit-set-form');
		$('form[data-edit-set-form-control=' + ptComposerFormLayoutSetControlID + ']').trigger('submit');
	});
});
</script>


<?php

}