<?php
$co = Loader::helper('lists/countries');
$countries = array_merge(array('' => t('Choose Country')), $co->getCountries());

if (isset($_POST['akCustomCountries'])) {
	$akCustomCountries = $_POST['akCustomCountries'];
} else if (!is_array($akCustomCountries)) {
	$akCustomCountries = array();
}
if (isset($_POST['akHasCustomCountries'])) {
	$akHasCustomCountries = $_POST['akHasCustomCountries'];
}

?>

<fieldset class="ccm-attribute ccm-attribute-address">
<legend><?php echo t('Address Options')?></legend>

<div class="form-group">
<label><?php echo t("Available Countries")?></label>
    <div class="radio">
        <label><?php echo $form->radio('akHasCustomCountries', 0, $akHasCustomCountries)?><?php echo t('All Available Countries')?></label>
    </div>
    <div class="radio">
        <label><?php echo $form->radio('akHasCustomCountries', 1, $akHasCustomCountries)?><?php echo t('Selected Countries')?></label>
    </div>
</div>
<div class="form-group">
	<select id="akCustomCountries" name="akCustomCountries[]" multiple size="7" disabled="disabled" class="form-control">
		<?php foreach ($countries as $key=>$val) { ?>
			<?php if (empty($key) || empty($val)) continue; ?>
			<option <?php echo (in_array($key, $akCustomCountries) || $akHasCustomCountries == 0 ?'selected ':'')?>value="<?php echo $key?>"><?php echo $val?></option>
		<?php } ?>
	</select>
</div>

<div class="form-group">
<label for="akDefaultCountry"><?php echo t('Default Country')?></label>
<?php echo $form->select('akDefaultCountry', $countries, $akDefaultCountry, array('classes'=>'form-control'))?>
</fieldset>
