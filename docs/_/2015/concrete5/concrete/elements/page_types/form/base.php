<?php
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\Page\Type\PublishTarget\Type\Type as PageTypePublishTargetType;
$form = Loader::helper('form');
$templates = array();
$ag = \Concrete\Core\Http\ResponseAssetGroup::get();
$ag->requireAsset('select2');
$pagetemplates = PageTemplate::getList();
foreach($pagetemplates as $pt) {
	$templates[$pt->getPageTemplateID()] = $pt->getPageTemplateDisplayName();
}
$targetTypes = PageTypePublishTargetType::getList();

$ptName = '';
$ptHandle = '';
$ptPageTemplateID = array();
$ptAllowedPageTemplates = 'A';
$ptDefaultPageTemplateID = 0;
$ptLaunchInComposer = 0;
$ptIsFrequentlyAdded = 1;
$token = 'add_page_type';
if (is_object($pagetype)) {
	$token = 'update_page_type';
	$ptName = $pagetype->getPageTypeName();
	$ptHandle = $pagetype->getPageTypeHandle();
	$ptLaunchInComposer = $pagetype->doesPageTypeLaunchInComposer();
	$ptDefaultPageTemplateID = $pagetype->getPageTypeDefaultPageTemplateID();
	$ptAllowedPageTemplates = $pagetype->getPageTypeAllowedPageTemplates();
    $ptIsFrequentlyAdded = $pagetype->isPageTypeFrequentlyAdded();
	$selectedtemplates = $pagetype->getPageTypeSelectedPageTemplateObjects();
	foreach($selectedtemplates as $pt) {
		$ptPageTemplateID[] = $pt->getPageTemplateID();
	}
}
?>

<?php echo Loader::helper('validation/token')->output($token)?>
	<div class="form-group">
		<?php echo $form->label('ptName', t('Page Type Name'))?>
    	<?php echo $form->text('ptName', $ptName, array('class' => 'span5'))?>
	</div>

	<div class="form-group">
		<?php echo $form->label('ptHandle', t('Page Type Handle'))?>
		<?php echo $form->text('ptHandle', $ptHandle, array('class' => 'span5'))?>
	</div>

	<div class="form-group">
		<?php echo $form->label('ptPageTemplateID', t('Default Page Template'))?>
		<?php echo $form->select('ptDefaultPageTemplateID', $templates, $ptDefaultPageTemplateID, array('class' => 'span5'))?>
	</div>

	<div class="form-group">
		<?php echo $form->label('ptLaunchInComposer', t('Launch in Composer?'))?>
		<?php echo $form->select('ptLaunchInComposer', array('0' => t('No'), '1' => t('Yes')), $ptLaunchInComposer, array('class' => 'span5'))?>
	</div>

    <div class="form-group">
        <?php echo $form->label('ptIsFrequentlyAdded', t('Is this page type frequently added?'))?>
        <?php echo $form->select('ptIsFrequentlyAdded', array('0' => t('No'), '1' => t('Yes')), $ptIsFrequentlyAdded, array('class' => 'span5'))?>
        <div class="help-block"><?php echo t('Frequently added page types are always visible in the Pages panel.')?></div>
    </div>

	<div class="form-group">
		<?php echo $form->label('ptAllowedPageTemplates', t('Allowed Page Templates'))?>
		<?php echo $form->select('ptAllowedPageTemplates', array('A' => t('All'), 'C' => t('Selected Page Templates'), 'X' => t('Everything But Selected')), $ptAllowedPageTemplates, array('class' => 'span3'))?>
	</div>

	<div class="form-group" data-form-row="page-templates">
		<?php echo $form->label('ptPageTemplateID', t('Page Templates'))?>
        <div style="width: 100%">
    		<?php echo $form->selectMultiple('ptPageTemplateID', $templates, $ptPageTemplateID, array('style' => 'width: 100%'))?>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->label('ptPublishTargetTypeID', t('Publish Method'))?>
        <?php for ($i = 0; $i < count($targetTypes); $i++) {
            $t = $targetTypes[$i];
            if (!is_object($pagetype)) {
                $selected = ($i == 0);
            } else {
                $selected = $pagetype->getPageTypePublishTargetTypeID();
            }
            ?>
            <div class="radio"><label><?php echo $form->radio('ptPublishTargetTypeID', $t->getPageTypePublishTargetTypeID(), $selected)?><?php echo $t->getPageTypePublishTargetTypeDisplayName()?></label></div>
        <?php } ?>
	</div>

	<?php foreach($targetTypes as $t) { 
		if ($t->hasOptionsForm()) {
		?>

		<div style="display: none" data-page-type-publish-target-type-id="<?php echo $t->getPageTypePublishTargetTypeID()?>">
			<?php $t->includeOptionsForm($pagetype);?>
		</div>

	<?php }

	} ?>

<script type="text/javascript">
$(function() {
	$('#ptPageTemplateID').removeClass('form-control').select2();
	$('input[name=ptPublishTargetTypeID]').on('click', function() {
		$('div[data-page-type-publish-target-type-id]').hide();
		var ptPublishTargetTypeID = $('input[name=ptPublishTargetTypeID]:checked').val();
		$('div[data-page-type-publish-target-type-id=' + ptPublishTargetTypeID + ']').show();
	});
	$('input[name=ptPublishTargetTypeID]:checked').trigger('click');
	$('select[name=ptAllowedPageTemplates]').on('change', function() {
		if ($(this).val() == 'A') {
			$('div[data-form-row=page-templates]').hide();
		} else {
			$('div[data-form-row=page-templates]').show();
		}
	}).trigger('change');
});
</script>