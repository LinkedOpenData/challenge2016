<?php
if (is_object($key)) {
	$uakProfileDisplay = $key->isAttributeKeyDisplayedOnProfile();
	$uakProfileEdit = $key->isAttributeKeyEditableOnProfile();
	$uakProfileEditRequired = $key->isAttributeKeyRequiredOnProfile();
	$uakRegisterEdit = $key->isAttributeKeyEditableOnRegister();
	$uakRegisterEditRequired = $key->isAttributeKeyRequiredOnRegister();
	$uakMemberListDisplay = $key->isAttributeKeyDisplayedOnMemberList();
	$uakIsActive = $key->isAttributeKeyActive();
}
?>
<?php $form = Loader::helper('form'); ?>
<fieldset>
    <legend><?php echo t('User Attribute Options')?></legend>
    <div class="form-group">
    <label class="control-label"><?php echo t('Public Display')?></label>
        <div class="checkbox">
            <label class="checkbox"><?php echo $form->checkbox('uakProfileDisplay', 1, $uakProfileDisplay)?> <?php echo t('Displayed in Public Profile.');?></label>
        </div>
        <div class="checkbox">
            <label class="checkbox"><?php echo $form->checkbox('uakMemberListDisplay', 1, $uakMemberListDisplay)?> <?php echo t('Displayed on Member List.');?></label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label"><?php echo t('Edit Mode')?></label>
        <div class="checkbox">
            <label class="checkbox"><?php echo $form->checkbox('uakProfileEdit', 1, $uakProfileEdit)?> <?php echo t('Editable in Profile.');?></label>
        </div>
        <div class="checkbox">
            <label class="checkbox"><?php echo $form->checkbox('uakProfileEditRequired', 1, $uakProfileEditRequired)?> <?php echo t('Editable and Required in Profile.');?></label>
        </div>
    </div>


    <div class="form-group">
        <label class="control-label"><?php echo t('Registration')?></label>
        <div class="checkbox">
            <label class="checkbox"><?php echo $form->checkbox('uakRegisterEdit', 1, $uakRegisterEdit)?> <?php echo t('Show on Registration Form.');?></label>
        </div>
        <div class="checkbox">
            <label class="checkbox"><?php echo $form->checkbox('uakRegisterEditRequired', 1, $uakRegisterEditRequired)?> <?php echo t('Require on Registration Form.');?></label>
        </div>
    </div>
</fieldset>

<script type="text/javascript">
$(function() {
	$('input[name=uakProfileEdit]').click(function() {
		if ($(this).prop('checked')) {
			$('input[name=uakProfileEditRequired]').attr('disabled', false);
		} else {
			$('input[name=uakProfileEditRequired]').attr('checked', false);
			$('input[name=uakProfileEditRequired]').attr('disabled', true);		
		}
	});

	$('input[name=uakRegisterEdit]').click(function() {
		if ($(this).prop('checked')) {
			$('input[name=uakRegisterEditRequired]').attr('disabled', false);
		} else {
			$('input[name=uakRegisterEditRequired]').attr('checked', false);
			$('input[name=uakRegisterEditRequired]').attr('disabled', true);		
		}
	});
	

	if ($('input[name=uakProfileEdit]').prop('checked')) {
		$('input[name=uakProfileEditRequired]').attr('disabled', false);
	} else {
		$('input[name=uakProfileEditRequired]').attr('checked', false);
		$('input[name=uakProfileEditRequired]').attr('disabled', true);		
	}	

	if ($('input[name=uakRegisterEdit]').prop('checked')) {
		$('input[name=uakRegisterEditRequired]').attr('disabled', false);
	} else {
		$('input[name=uakRegisterEditRequired]').attr('checked', false);
		$('input[name=uakRegisterEditRequired]').attr('disabled', true);		
	}	

});
</script>