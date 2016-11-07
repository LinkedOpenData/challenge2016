<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="ccm-ui">

<form method="post" action="<?php echo $controller->action('submit')?>" data-dialog-form="search-customize">

	<fieldset>
		<legend><?php echo t('Choose Columns')?></legend>

	<div class="form-group">
		<label class="control-label"><?php echo t('Standard Properties')?></label>

	<?php
    $columns = $fldca->getColumns();
    foreach ($columns as $col) { ?>

		<div class="checkbox"><label><?php echo $form->checkbox($col->getColumnKey(), 1, $fldc->contains($col))?> <span><?php echo $col->getColumnName()?></span></label></div>

	<?php } ?>

	</div>

	<div class="form-group">
		<label class="control-label"><?php echo t('Additional Attributes')?></label>

	<?php foreach ($list as $ak) { ?>

		<div class="checkbox"><label><?php echo $form->checkbox('ak_' . $ak->getAttributeKeyHandle(), 1, $fldc->contains($ak))?> <span><?php echo $ak->getAttributeKeyDisplayName()?></span></label></div>

	<?php } ?>

	</div>

	<fieldset>
		<legend><?php echo t('Column Order')?></legend>

		<p><?php echo t('Click and drag to change column order.')?></p>

		<ul class="list-unstyled" data-search-column-list="<?php echo $type?>">
		<?php foreach ($fldc->getColumns() as $col) { ?>
			<li style="cursor: move" data-field-order-column="<?php echo $col->getColumnKey()?>"><input type="hidden" name="column[]" value="<?php echo $col->getColumnKey()?>" /><?php echo $col->getColumnName()?></li>
		<?php } ?>
		</ul>
	</fieldset>

	<fieldset>
		<legend><?php echo t('Sort By')?></legend>
		<?php $ds = $fldc->getDefaultSortColumn(); ?>

		<div class="form-group">
			<label class="control-label" for="fSearchDefaultSort"><?php echo t('Default Column')?></label>
			<select <?php if (count($fldc->getSortableColumns()) == 0) { ?>disabled="true"<?php } ?> class="form-control" data-search-select-default-column="<?php echo $type?>" id="fSearchDefaultSort" name="fSearchDefaultSort">
			<?php foreach ($fldc->getSortableColumns() as $col) { ?>
				<option id="<?php echo $col->getColumnKey()?>" value="<?php echo $col->getColumnKey()?>" <?php if ($col->getColumnKey() == $ds->getColumnKey()) { ?> selected="true" <?php } ?>><?php echo $col->getColumnName()?></option>
			<?php } ?>
			</select>
		</div>

		<div class="form-group">
			<label class="control-label" for="fSearchDefaultSortDirection"><?php echo t('Direction')?></label>
			<select <?php if (count($fldc->getSortableColumns()) == 0) { ?>disabled="true"<?php } ?> class="form-control" id="fSearchDefaultSortDirection" name="fSearchDefaultSortDirection">
				<option value="asc" <?php if ($ds->getColumnDefaultSortDirection() == 'asc') { ?> selected="true" <?php } ?>><?php echo t('Ascending')?></option>
				<option value="desc" <?php if ($ds->getColumnDefaultSortDirection() == 'desc') { ?> selected="true" <?php } ?>><?php echo t('Descending')?></option>
			</select>
		</div>

	</fieldset>

	<div class="dialog-buttons">
	<button class="btn btn-default pull-left" data-dialog-action="cancel"><?php echo t('Cancel')?></button>
	<button type="button" data-dialog-action="submit" class="btn btn-primary pull-right"><?php echo t('Save')?></button>
	</div>

</form>
</div>
