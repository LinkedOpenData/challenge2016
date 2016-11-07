<?php defined('C5_EXECUTE') or die("Access Denied."); ?>


<?php if (is_object($pagetype)) { ?>

	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper($pagetype->getPageTypeName(), false, false, false)?>
	<form method="post" data-form="composer" class="form-horizontal">
	<div class="ccm-pane-body">
		<?php Loader::helper('concrete/composer')->display($pagetype, $draft); ?>
	</div>
	<div class="ccm-pane-footer">
		<?php Loader::helper('concrete/composer')->displayButtons($pagetype, $draft); ?>
	</div>

	</form>

	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>

<?php } else { ?>

	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Composer'), false, 'span10 offset1')?>

	<?php if (count($pagetypes) > 0) { ?>
	<h3><?php echo t('What would you like to write?')?></h3>
	<ul class="item-select-list">
	<?php foreach($pagetypes as $pt) { 
		$ccp = new Permissions($pt);
		if ($ccp->canEditPageTypeInComposer()) { 
		?>
		<li class="item-select-page"><a href="<?php echo $view->url('/dashboard/composer/write', 'composer', $pt->getPageTypeID())?>"><?php echo $pt->getPageTypeName()?></a></li>
		<?php } ?>
	<?php } ?>
	</ul>
	<?php } else { ?>
		<p><?php echo t('You do not have any page types.')?></p>
	<?php } ?>


	<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper()?>


<?php } ?>
