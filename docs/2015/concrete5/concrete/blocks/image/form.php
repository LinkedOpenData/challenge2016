<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
$bf = null;
$bfo = null;

if ($controller->getFileID() > 0) { 
	$bf = $controller->getFileObject();
}
if ($controller->getFileOnstateID() > 0) { 
	$bfo = $controller->getFileOnstateObject();

}
?>

<fieldset>

    <legend><?php echo t('Files')?></legend>
<?php
$args = array();
$constrain = $maxWidth > 0 || $maxHeight > 0;
if ($maxWidth == 0) {
    $maxWidth = '';
}
if ($maxHeight == 0) {
    $maxHeight = '';
}

?>

<div class="form-group">
	<label class="control-label"><?php echo t('Image')?></label>
	<?php echo $al->image('ccm-b-image', 'fID', t('Choose Image'), $bf, $args);?>
</div>
<div class="form-group">
	<label class="control-label"><?php echo t('Image Hover')?> <small style="color:#999999; font-weight: 200;"><?php echo t('(Optional)'); ?></small></label>
	<?php echo $al->image('ccm-b-image-onstate', 'fOnstateID', t('Choose Image On-State'), $bfo, $args);?>
</div>

</fieldset>
<hr/>

<fieldset>
    <legend><?php echo t('HTML')?></legend>

<div class="form-group">
	<?php echo $form->label('imageLinkType', t('Image Link'))?>
	<select name="linkType" id="imageLinkType" class="form-control" style="width: 60%;">
		<option value="0" <?php echo (empty($externalLink) && empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php echo t('None')?></option>
		<option value="1" <?php echo (empty($externalLink) && !empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php echo t('Another Page')?></option>
		<option value="2" <?php echo (!empty($externalLink) ? 'selected="selected"' : '')?>><?php echo t('External URL')?></option>
	</select>
</div>

<div id="imageLinkTypePage" style="display: none;" class="form-group">
	<?php echo $form->label('internalLinkCID', t('Choose Page:'))?>
	<?php echo Loader::helper('form/page_selector')->selectPage('internalLinkCID', $internalLinkCID); ?>
</div>

<div id="imageLinkTypeExternal" style="display: none;" class="form-group">
	<?php echo $form->label('externalLink', t('URL'))?>
	<?php echo $form->text('externalLink', $externalLink, array('style'=>'width: 60%;')); ?>
</div>


<div class="form-group">
	<?php echo $form->label('altText', t('Alt. Text'))?>
	<?php echo $form->text('altText', $altText, array('style'=>'width: 60%;')); ?>
</div>

<div class="form-group">
    <?php echo $form->label('title', t('Title'))?>
    <?php echo $form->text('title', $title, array('style'=>'width: 60%;')); ?>
</div>

</fieldset>

<fieldset>
    <legend><?php echo t('Resize Image')?></legend>

    <div class="form-group">
        <div class="checkbox" data-checkbox-wrapper="constrain-image">
            <label><?php echo $form->checkbox('constrainImage', 1, $constrain)?>
            <?php echo t('Constrain Image Size')?></label>
        </div>
    </div>

    <div data-fields="constrain-image" style="display: none">
        <div class="form-group">
        <?php echo $form->label('maxWidth', t('Max Width'))?>
        <?php echo $form->text('maxWidth', $maxWidth, array('style' => 'width: 60px')); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label('maxHeight', t('Max Height'))?>
            <?php echo $form->text('maxHeight', $maxHeight, array('style' => 'width: 60px')); ?>
        </div>
    </div>

</fieldset>


<script type="text/javascript">
refreshImageLinkTypeControls = function() {
	var linkType = $('#imageLinkType').val();
	$('#imageLinkTypePage').toggle(linkType == 1);
	$('#imageLinkTypeExternal').toggle(linkType == 2);
}

$(document).ready(function() {
	$('#imageLinkType').change(refreshImageLinkTypeControls);

    $('div[data-checkbox-wrapper=constrain-image] input').on('change', function() {
        if ($(this).is(':checked')) {
            $('div[data-fields=constrain-image]').show();
        } else {
            $('div[data-fields=constrain-image]').hide();
        }
    }).trigger('change');
	refreshImageLinkTypeControls();
});
</script>