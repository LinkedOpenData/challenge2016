<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<ul class="ccm-inline-toolbar ccm-ui">
	<li class="ccm-inline-toolbar-icon-cell"><a href="#" data-gathering-refresh="<?php echo $gathering->getGatheringID()?>"><i class="fa fa-refresh"></i></a></li>
	<li class="ccm-inline-toolbar-icon-cell"><a href="<?php echo Loader::helper('concrete/urls')->getBlockTypeToolsURL($bt)?>/edit?cID=<?php echo $c->getCollectionID()?>&arHandle=<?php echo Loader::helper('text')->entities($a->getAreaHandle())?>&bID=<?php echo $b->getBlockID()?>&tab=sources" class="dialog-launch" dialog-title="<?php echo t('Data Sources')?>" dialog-width="<?php echo $controller->getInterfaceWidth()?>" dialog-height="<?php echo $controller->getInterfaceHeight()?>"><i class="fa fa-filter"></i></a></li>
	<li class="ccm-inline-toolbar-icon-cell"><a href="<?php echo Loader::helper('concrete/urls')->getBlockTypeToolsURL($bt)?>/edit?cID=<?php echo $c->getCollectionID()?>&arHandle=<?php echo Loader::helper('text')->entities($a->getAreaHandle())?>&bID=<?php echo $b->getBlockID()?>&tab=output" class="dialog-launch" dialog-title="<?php echo t('Output')?>" dialog-width="<?php echo $controller->getInterfaceWidth()?>" dialog-height="<?php echo $controller->getInterfaceHeight()?>"><i class="fa fa-resize-full"></i></a></li>
	<li class="ccm-inline-toolbar-icon-cell"><a href="<?php echo Loader::helper('concrete/urls')->getBlockTypeToolsURL($bt)?>/edit?cID=<?php echo $c->getCollectionID()?>&arHandle=<?php echo Loader::helper('text')->entities($a->getAreaHandle())?>&bID=<?php echo $b->getBlockID()?>&tab=posting" class="dialog-launch" dialog-title="<?php echo t('Posting')?>" dialog-width="<?php echo $controller->getInterfaceWidth()?>" dialog-height="<?php echo $controller->getInterfaceHeight()?>"><i class="fa fa-pencil"></i></a></li>
	<li class="ccm-inline-toolbar-button ccm-inline-toolbar-button-save"><button type="button" data-toolbar-button-action="exit-gathering"><?php echo t("Done")?></button></li>
</ul>

<script type="text/javascript">
$(function() {
	$('button[data-toolbar-button-action=exit-gathering]').on('click', function() {
		ConcreteEvent.fire('EditModeExitInline');
	});
});
</script>

<?php
Loader::element('gathering/display', array(
	'gathering' => $gathering,
	'list' => $itemList,
	'itemsPerPage' => $itemsPerPage,
	'showTileControls' => true
));
