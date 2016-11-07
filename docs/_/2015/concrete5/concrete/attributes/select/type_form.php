<?php

function getAttributeOptionHTML($v){ 
	if ($v == 'TEMPLATE') {
		$akSelectValueID = 'TEMPLATE_CLEAN';
		$akSelectValue = 'TEMPLATE';
	} else {
		if ($v->getSelectAttributeOptionTemporaryID() != false) {
			$akSelectValueID = $v->getSelectAttributeOptionTemporaryID();
		} else {
			$akSelectValueID = $v->getSelectAttributeOptionID();
		}
		$akSelectValue = $v->getSelectAttributeOptionValue();
	}
		?>
		<div id="akSelectValueDisplay_<?php echo $akSelectValueID?>" >
			<div class="rightCol">
				<input class="btn btn-primary" type="button" onClick="ccmAttributesHelper.editValue('<?php echo addslashes($akSelectValueID)?>')" value="<?php echo t('Edit')?>" />
				<input class="btn btn-danger" type="button" onClick="ccmAttributesHelper.deleteValue('<?php echo addslashes($akSelectValueID)?>')" value="<?php echo t('Delete')?>" />
			</div>			
			<span onClick="ccmAttributesHelper.editValue('<?php echo addslashes($akSelectValueID)?>')" id="akSelectValueStatic_<?php echo $akSelectValueID?>" class="leftCol"><?php echo $akSelectValue ?></span>
		</div>
		<div id="akSelectValueEdit_<?php echo $akSelectValueID?>" style="display:none">
			<span class="leftCol">
				<input name="akSelectValueOriginal_<?php echo $akSelectValueID?>" type="hidden" value="<?php echo $akSelectValue?>" />
				<?php if (is_object($v) && $v->getSelectAttributeOptionTemporaryID() == false) { ?>
					<input id="akSelectValueExistingOption_<?php echo $akSelectValueID?>" name="akSelectValueExistingOption_<?php echo $akSelectValueID?>" type="hidden" value="<?php echo $akSelectValueID?>" />
				<?php } else { ?>
					<input id="akSelectValueNewOption_<?php echo $akSelectValueID?>" name="akSelectValueNewOption_<?php echo $akSelectValueID?>" type="hidden" value="<?php echo $akSelectValueID?>" />
				<?php } ?>
				<input id="akSelectValueField_<?php echo $akSelectValueID?>" onkeypress="ccmAttributesHelper.keydownHandler(event);" class="akSelectValueField form-control" data-select-value-id="<?php echo $akSelectValueID; ?>" name="akSelectValue_<?php echo $akSelectValueID?>" type="text" value="<?php echo $akSelectValue?>" size="40" />
			</span>		
			<div class="rightCol">
				<input class="btn btn-default" type="button" onClick="ccmAttributesHelper.editValue('<?php echo addslashes($akSelectValueID)?>')" value="<?php echo t('Cancel')?>" />
				<input class="btn btn-success" type="button" onClick="ccmAttributesHelper.changeValue('<?php echo addslashes($akSelectValueID)?>')" value="<?php echo t('Save')?>" />
			</div>		
		</div>	
		<div class="ccm-spacer">&nbsp;</div>
<?php } ?>

<fieldset class="ccm-attribute ccm-attribute-select">
<legend><?php echo t('Select Options')?></legend>

<div class="form-group">
    <label><?php echo t("Multiple Values")?></label>
    <div class="checkbox">
        <label>
            <?php echo $form->checkbox('akSelectAllowMultipleValues', 1, $akSelectAllowMultipleValues)?> <span><?php echo t('Allow multiple options to be chosen.')?></span>
        </label>
    </div>
</div>

<div class="form-group">
    <label><?php echo t("User Submissions")?></label>
    <div class="checkbox">
        <label>
            <?php echo $form->checkbox('akSelectAllowOtherValues', 1, $akSelectAllowOtherValues)?> <span><?php echo t('Allow users to add to this list.')?></span>
        </label>
    </div>
</div>

<div class="form-group">
<label for="akSelectOptionDisplayOrder"><?php echo t("Option Order")?></label>
	<?php
	$displayOrderOptions = array(
		'display_asc' => t('Display Order'),
		'alpha_asc' => t('Alphabetical'),
		'popularity_desc' => t('Most Popular First')
	);
	?>

	<?php echo $form->select('akSelectOptionDisplayOrder', $displayOrderOptions, $akSelectOptionDisplayOrder)?>
</div>

<div class="clearfix">
<label><?php echo t('Values')?></label>
<div class="input">
	<div id="attributeValuesInterface">
	<div id="attributeValuesWrap">
	<?php
	Loader::helper('text');
	foreach($akSelectValues as $v) { 
		if ($v->getSelectAttributeOptionTemporaryID() != false) {
			$akSelectValueID = $v->getSelectAttributeOptionTemporaryID();
		} else {
			$akSelectValueID = $v->getSelectAttributeOptionID();
		}
		?>
		<div id="akSelectValueWrap_<?php echo $akSelectValueID?>" class="akSelectValueWrap akSelectValueWrapSortable">
			<?php echo getAttributeOptionHTML( $v )?>
		</div>
	<?php } ?>
	</div>
	
	<div id="akSelectValueWrapTemplate" class="akSelectValueWrap" style="display:none">
		<?php echo getAttributeOptionHTML('TEMPLATE') ?>
	</div>
	
	<div id="addAttributeValueWrap" class="form-inline">
		<input id="akSelectValueFieldNew" name="akSelectValueNew" type="text" value="<?php echo $defaultNewOptionNm ?>" size="40"  class="form-control"
		onfocus="ccmAttributesHelper.clrInitTxt(this,'<?php echo $defaultNewOptionNm ?>','faint',0)" 
		onblur="ccmAttributesHelper.clrInitTxt(this,'<?php echo $defaultNewOptionNm ?>','faint',1)"
		onkeypress="ccmAttributesHelper.keydownHandler(event);"
		 /> 
		<input class="btn btn-primary" type="button" onClick="ccmAttributesHelper.saveNewOption(); $('#ccm-attribute-key-form').unbind()" value="<?php echo t('Add') ?>" />
	</div>
	</div>

</div>
</div>


</fieldset>
<script type="text/javascript">
//<![CDATA[
$(function() {
	ccmAttributesHelper.makeSortable();
});
//]]>
</script>
