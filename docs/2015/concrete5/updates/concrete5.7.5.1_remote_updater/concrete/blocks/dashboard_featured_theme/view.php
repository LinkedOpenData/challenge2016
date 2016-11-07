<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<h6><?php echo t('Featured Theme')?></h6>
<?php if (is_object($remoteItem)) { ?>
	<div class="clearfix">
	<img src="<?php echo $remoteItem->getRemoteIconURL()?>" width="50" height="50" class="pull-right" style="margin-left: 10px; margin-bottom: 10px" />
	<h4><?php echo $remoteItem->getName()?></h4>
	<p><?php echo $remoteItem->getDescription()?></p>
	</div>
	
	<a href="<?php echo $remoteItem->getRemoteURL()?>" class="btn btn-default"><?php echo t('Learn More')?></a>
<?php } else { ?>
	<p><?php echo t("Cannot retrieve data from the concrete5 marketplace.")?></p>
<?php } ?>