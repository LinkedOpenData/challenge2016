<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
$ctArray = PageType::getList();
$types = array();
foreach($ctArray as $cta) {
    $types[$cta->getPageTypeID()] = $cta->getPageTypeDisplayName();
}
$ptID = 0;
if (is_object($pagetype) && $pagetype->getPageTypePublishTargetTypeID() == $type->getPageTypePublishTargetTypeID()) {
	$configuredTarget = $pagetype->getPageTypePublishTargetObject();
	$ptID = $configuredTarget->getPageTypeID();
}
?>
	<div class="control-group">
		<?php echo $form->label('ptID', t('Publish Beneath Pages of Type'))?>
		<div class="controls">
			<?php echo $form->select('ptID', $types, $ptID)?>
		</div>
	</div>