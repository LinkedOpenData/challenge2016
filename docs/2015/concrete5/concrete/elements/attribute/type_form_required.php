<?php 
use \Concrete\Core\Attribute\Key\Category as AttributeKeyCategory;
$c = Page::getCurrentPage();

$form = Loader::helper('form'); 
$ih = Loader::helper("concrete/ui");
$valt = Loader::helper('validation/token');
$akName = '';
$akIsSearchable = 1;
$asID = 0;

if (is_object($key)) {
	if (!isset($akHandle)) {
		$akHandle = $key->getAttributeKeyHandle();
	}
	$akName = $key->getAttributeKeyName();
	$akIsSearchable = $key->isAttributeKeySearchable();
	$akIsSearchableIndexed = $key->isAttributeKeyContentIndexed();
	$sets = $key->getAttributeSets();
	if (count($sets) == 1) {
		$asID = $sets[0]->getAttributeSetID();
	}
	print $form->hidden('akID', $key->getAttributeKeyID());
}
?>

<?php if (is_object($key)) { ?>
	<?php
	$valt = Loader::helper('validation/token');
	$ih = Loader::helper('concrete/ui');
	$delConfirmJS = t('Are you sure you want to remove this attribute?');
	?>
	<script type="text/javascript">
	deleteAttribute = function() {
		if (confirm('<?php echo $delConfirmJS?>')) { 
			location.href = "<?php echo $view->action('delete', $key->getAttributeKeyID(), $valt->generate('delete_attribute'))?>";				
		}
	}
	</script>

<div class="ccm-dashboard-header-buttons">
	<button type="button" class="btn btn-danger" onclick="deleteAttribute()"><?php echo t('Delete Attribute')?></button>
</div>

<?php } ?>


<fieldset>
<legend><?php echo t('%s: Basic Details', $type->getAttributeTypeDisplayName())?></legend>

<div class="form-group">
	<?php echo $form->label('akHandle', t('Handle'))?>
	<div class="input-group">
	<?php echo $form->text('akHandle', $akHandle)?>
	<span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
	</div>
</div>


<div class="form-group">
	<?php echo $form->label('akName', t('Name'))?>
	<div class="input-group">
		<?php echo $form->text('akName', $akName)?>
		<span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
	</div>
</div>

<?php if ($category->allowAttributeSets() == AttributeKeyCategory::ASET_ALLOW_SINGLE) { ?>
<div class="form-group">
<?php echo $form->label('asID', t('Set'))?>
<div class="controls">
	<?php
		$sel = array('0' => t('** None'));
		$sets = $category->getAttributeSets();
		foreach($sets as $as) {
			$sel[$as->getAttributeSetID()] = $as->getAttributeSetDisplayName();
		}
		print $form->select('asID', $sel, $asID);
		?>
</div>
</div>
<?php } ?>

<div class="form-group">
<label class="control-label"><?php echo t('Searchable')?></label>

<?php
	$category_handle = $category->getAttributeKeyCategoryHandle();
	$keyword_label = t('Content included in "Keyword Search".');
	$advanced_label = t('Field available in "Advanced Search".');
	switch ($category_handle) {
		case 'collection':
			$keyword_label = t('Content included in sitewide page search index.');
			$advanced_label = t('Field available in Dashboard Page Search.');
			break;
		case 'file':
			$keyword_label = t('Content included in file search index.');
			$advanced_label = t('Field available in File Manager Search.');			
			break;
		case 'user':
			$keyword_label = t('Content included in user keyword search.');
			$advanced_label = t('Field available in Dashboard User Search.');
			break;
	}
	?>
	<div class="checkbox"><label><?php echo $form->checkbox('akIsSearchableIndexed', 1, $akIsSearchableIndexed)?> <?php echo $keyword_label?></label></div>
	<div class="checkbox"><label><?php echo $form->checkbox('akIsSearchable', 1, $akIsSearchable)?> <?php echo $advanced_label?></label></div>
</div>

</fieldset>

<?php echo $form->hidden('atID', $type->getAttributeTypeID())?>
<?php echo $form->hidden('akCategoryID', $category->getAttributeKeyCategoryID()); ?>
<?php echo $valt->output('add_or_update_attribute')?>
<?php 
if ($category->getPackageID() > 0) { 
	@Loader::packageElement('attribute/categories/' . $category->getAttributeKeyCategoryHandle(), $category->getPackageHandle(), array('key' => $key));
} else {
	@Loader::element('attribute/categories/' . $category->getAttributeKeyCategoryHandle(), array('key' => $key));
}
?>

<?php $type->render('type_form', $key); ?>


<div class="ccm-dashboard-form-actions-wrapper">
<div class="ccm-dashboard-form-actions">
	<a href="<?php echo URL::page($c)?>" class="btn pull-left btn-default"><?php echo t('Back')?></a>
<?php if (is_object($key)) { ?>
	<button type="submit" class="btn btn-primary pull-right"><?php echo t('Save')?></button>
<?php } else { ?>
	<button type="submit" class="btn btn-primary pull-right"><?php echo t('Add')?></button>
<?php } ?>
</div>
</div>

