<?php defined('C5_EXECUTE') or die("Access Denied.");?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Captcha Settings'), false, 'span10 offset1', (!is_object($activeCaptcha) || (!$activeCaptcha->hasOptionsForm())))?>
<form method="post" id="site-form" action="<?php echo $view->action('update_captcha')?>">
<?php if (is_object($activeCaptcha) && $activeCaptcha->hasOptionsForm()) { ?>
<?php } ?>
<?php echo $this->controller->token->output('update_captcha')?>
	<?php if (count($captchas) > 0) { ?>

		<div class="form-group">
		<?php echo $form->label('activeCaptcha', t('Active Captcha'))?>
		<?php
		$activeHandle = '';
		if (is_object($activeCaptcha)) {
			$activeHandle = $activeCaptcha->getSystemCaptchaLibraryHandle();
		}
		?>
		
		<?php echo $form->select('activeCaptcha', $captchas, $activeHandle, array('class' => 'span4'))?>
		</div>
		
		<?php if (is_object($activeCaptcha)) {
			if ($activeCaptcha->hasOptionsForm()) {
				if ($activeCaptcha->getPackageID() > 0) { 
					Loader::packageElement('system/captcha/' . $activeCaptcha->getSystemCaptchaLibraryHandle() . '/form', $activeCaptcha->getPackageHandle());
				} else {
					Loader::element('system/captcha/' . $activeCaptcha->getSystemCaptchaLibraryHandle() . '/form');
				}
			}
		} ?>


	<?php } else { ?>
		<p><?php echo t('You have no captcha libraries installed.')?></p>
	<?php } ?>

<?php if (is_object($activeCaptcha)) { ?>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
		<?php echo Loader::helper('concrete/ui')->submit(t('Save'), 'submit', 'right', 'btn-primary')?>
        </div>
	</div>
<?php } ?>	

	
</form>

<script type="text/javascript">
$(function() {
	$('select[name=activeCaptcha]').change(function() {
		$('#site-form').submit();
	});
});
</script>
