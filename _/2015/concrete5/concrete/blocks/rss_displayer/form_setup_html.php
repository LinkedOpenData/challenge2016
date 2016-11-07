<?php defined('C5_EXECUTE') or die("Access Denied.");

/* @var $form \Concrete\Core\Form\Service\Form */

?>
<div class="form-group">
    <?php echo $form->label('url', t('Feed URL')) ?>
    <input name="url" class="form-control" placeholder="<?php echo h(t('Feed URL')) ?>" value="<?php echo h($rssObj->url) ?>" type="text" required="required" />
</div>
<div class="form-group">
    <label for="title">
        <?php echo t('Feed Title') ?>
        <span class="help-block" style="font-weight: normal;display: inline">(<?php echo t('Optional') ?>)</span>
    </label>
    <input name="title" class="form-control" placeholder="<?php echo h(t('Feed Title')) ?>" value="<?php echo h($rssObj->title) ?>"/>
</div>
<div class="form-group">
    <?php echo $form->label('dateFormat', t('Date Format')) ?>
    <?php
    $dateFormats = $rssObj->getDefaultDateTimeFormats();
    $dateFormats[':custom:'] = t('Custom date/time format');
    $standardDateFormat = $rssObj->dateFormat;
    $customDateFormat = '';
    if(!$standardDateFormat) {
        reset($dateFormats);
        $standardDateFormat = key($dateFormats);
    }
    if(!array_key_exists($standardDateFormat, $dateFormats)) {
        $customDateFormat = $standardDateFormat;
        $standardDateFormat = ':custom:';
    }
    echo $form->select('standardDateFormat', $dateFormats, $standardDateFormat);
    ?>
</div>
<?php
?><div class="form-group"<?php echo ($standardDateFormat === ':custom:') ? '' : ' style="display: none"'; ?>>
    <?php echo $form->label('customDateFormat', t('Custom date format')); ?>
    <?php echo $form->text('customDateFormat', $customDateFormat); ?>
    <a href="http://php.net/manual/function.date.php" target="_blank"><?php echo t('See the PHP manual')?></a><?php
?></div>
<script>
$(document).ready(function() {
	function update() {
		$('#customDateFormat').closest('div.form-group')[($('#standardDateFormat').val() === ':custom:') ? 'show' : 'hide']('fast');
	}
	$('#standardDateFormat').on('change', function() { update(); });
});
</script>
<div class="form-group">
    <?php echo $form->label('itemsToDisplay', t('Items to Show')) ?>
    <input name="itemsToDisplay" class="form-control" placeholder="10" value="<?php echo h($rssObj->itemsToDisplay) ?>"/>
</div>
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" value="1" name="showSummary"<?php echo (!!$rssObj->showSummary ? ' checked' : '') ?> />
            <?php echo t('Include Summary') ?>
        </label>
    </div>
</div>
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" value="1"
               name="launchInNewWindow"<?php echo (!!$rssObj->launchInNewWindow ? ' checked' : '') ?> />
            <?php echo t('Open links in a new window') ?>
        </label>
    </div>
</div>
