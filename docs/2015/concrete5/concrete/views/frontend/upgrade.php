<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="row">
<div class="col-sm-10 col-sm-offset-1">

<div class="page-header">
	<h1><?php echo t('Upgrade concrete5')?></h1>
</div>
<p>
<?php echo $status?>
</p>

<?php if($had_failures) { ?>
<div class="alert-message block-message error">
	<?php echo t('These errors are most likely related to incompatible add-ons, please upgrade any add-ons and re-run to this script to complete the conversion of your data.')?>
</div>
<?php } ?>

<?php if ($completeMessage) { ?>
	<?php echo $completeMessage?>
<?php } ?>

<?php if ($do_upgrade) { ?>
<p>	<?php echo t('To proceed with the upgrade, click below.')?></p>


	<form method="post" action="<?php echo $controller->action('submit')?>">
	<div class="well" style="text-align: right">
	<input type="submit" name="do_upgrade" class="btn btn-primary" value="<?php echo t('Upgrade')?>"  />
	</div>
	</form>



<?php } else { ?>

	<div class="well" style="text-align: left">
	    <a href="<?php echo DIR_REL?>/" class="btn btn-default"><?php echo t('Back to Home')?></a>
  	</div>
	
	<?php if(!isset($hide_force) || !$hide_force) { ?>
        <p>
        <?php echo t('<a href="%s">Click here</a> if you would like to re-run this script.', DIR_REL . '/' . DISPATCHER_FILENAME . '/ccm/system/upgrade?force=1')?>
        </p>
    <?php } ?>
<?php } ?>

</div>
</div>
