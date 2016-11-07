<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="page-header">
	<h1><?php echo t('Site Registration')?></h1>
</div>
</div>
</div>

<?php
$attribs = UserAttributeKey::getRegistrationList();

if($registerSuccess) { ?>
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<?php	switch($registerSuccess) {
		case "registered":
			?>
			<p><strong><?php echo $successMsg ?></strong><br/><br/>
			<a href="<?php echo $view->url('/')?>"><?php echo t('Return to Home')?></a></p>
			<?php
		break;
		case "validate":
			?>
			<p><?php echo $successMsg[0] ?></p>
			<p><?php echo $successMsg[1] ?></p>
			<p><a href="<?php echo $view->url('/')?>"><?php echo t('Return to Home')?></a></p>
			<?php
		break;
		case "pending":
			?>
			<p><?php echo $successMsg ?></p>
			<p><a href="<?php echo $view->url('/')?>"><?php echo t('Return to Home')?></a></p>
            <?php
		break;
	} ?>
</div>
</div>
<?php
} else { ?>
	<form method="post" action="<?php echo $view->url('/register', 'do_register')?>" class="form-stacked">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<fieldset>
					<legend><?php echo t('Your Details')?></legend>
					<?php
					if ($displayUserName) {
						?>
						<div class="form-group">
							<?php echo $form->label('uName',t('Username'))?>
                            <?php echo $form->text('uName')?>
						</div>
						<?php
					}
					?>
                    <div class="form-group">
                        <?php echo $form->label('uEmail',t('Email Address'))?>
                        <?php echo $form->text('uEmail')?>
                    </div>
                    <div class="form-group">
						<?php echo $form->label('uPassword',t('Password'))?>
					    <?php echo $form->password('uPassword',array('autocomplete' => 'off'))?>
					</div>
                    <div class="form-group">
						<?php echo $form->label('uPasswordConfirm',t('Confirm Password'))?>
						<?php echo $form->password('uPasswordConfirm',array('autocomplete' => 'off'))?>
					</div>

				</fieldset>
			</div>
		</div>
		<?php
		if (count($attribs) > 0) {
			?>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<fieldset>
						<legend><?php echo t('Options')?></legend>
						<?php
						$af = Loader::helper('form/attribute');
						foreach($attribs as $ak) {
							echo $af->display($ak, $ak->isAttributeKeyRequiredOnRegister());
						}
						?>
					</fieldset>
				</div>
			</div>
			<?php
		}
		if (Config::get('concrete.user.registration.captcha')) {
			?>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 ">

					<div class="form-group">
						<?php
						$captcha = Loader::helper('validation/captcha');
						echo $captcha->label();
						?>
                        <?php
                        $captcha->showInput();
                        $captcha->display();
                        ?>
					</div>
				</div>
			</div>

		<?php } ?>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="form-actions">
					<?php echo $form->hidden('rcID', $rcID); ?>
					<?php echo $form->submit('register', t('Register') . ' &gt;', array('class' => 'btn-lg btn-primary'))?>
				</div>
			</div>
		</div>
	</form>

	<?php
}
?>
