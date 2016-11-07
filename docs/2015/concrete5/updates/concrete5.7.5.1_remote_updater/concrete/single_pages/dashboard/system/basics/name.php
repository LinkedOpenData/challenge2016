<?php defined('C5_EXECUTE') or die("Access Denied.");?>
<form method="post" class="ccm-dashboard-content-form" action="<?php echo $view->action('update_sitename')?>">
	<?php echo $this->controller->token->output('update_sitename')?>

	<fieldset>
	<div class="form-group">
		<label for="SITE" class="launch-tooltip control-label" data-placement="right" title="<?php echo t('By default, site name is displayed in the browser title bar. It is also the default name for your project on concrete5.org')?>"><?php echo t('Site Name')?></label>
		<?php echo $form->text('SITE', $site, array('class' => 'span4'))?>
	</div>
	</fieldset>
	<div class="ccm-dashboard-form-actions-wrapper">
	<div class="ccm-dashboard-form-actions">
		<button class="pull-right btn btn-primary" type="submit" ><?php echo t('Save')?></button>
	</div>
	</div>
</form>