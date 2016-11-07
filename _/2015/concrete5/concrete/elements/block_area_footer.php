<?php
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\Area\SubArea;
?>

<?php

// simple file that controls the adding of blocks.

// $blockTypes is an array using the btID as the key and btHandle as the value.
// It is defined within Area->_getAreaAddBlocks(), which then calls a
// function in Content to include the file

// note, we're also passed an area & collection object from the original function

$arHandle = $a->getAreaHandle();
$c = $a->getAreaCollectionObject();
$cID = $c->getCollectionID();
$u = new User();
$ap = new Permissions($a);
$cp = new Permissions($c);
$class = 'ccm-area-footer';

?>
</div>

<div class="<?php echo $class?> ccm-ui">

<div class="ccm-area-footer-handle" data-area-menu-handle="<?php echo $a->getAreaID()?>" id="area-menu-footer-<?php echo $a->getAreaID()?>"><span><i class="fa fa-share-alt"></i> <?php echo $a->getAreaDisplayName()?></span></div>

<div class="popover fade" data-area-menu="area-menu-a<?php echo $a->getAreaID()?>">
	<div class="arrow"></div>
	<div class="popover-inner">
	<ul class="dropdown-menu">
	<?php
		$showAreaDesign = ($ap->canEditAreaDesign() && Config::get('concrete.design.enable_custom') == true);
		$showAreaLayouts = ($ap->canAddLayoutToArea() && Config::get('concrete.design.enable_layouts') == true && (!$a->isGlobalArea()));
		$canEditAreaPermissions = ($ap->canEditAreaPermissions() && Config::get('concrete.permissions.model') != 'simple' && (!$a->isGlobalArea()));
        $showAddBlock = !!$ap->canAddBlocks();

    if ($showAddBlock) {
        ?>
        <li><a href='#' data-menu-action="area-add-block"><?php echo t('Add Block') ?></a></li>
        <?php
    }
    ?>

	<?php if ($showAreaDesign || $showAreaLayouts) { ?>
		<?php if ($showAreaDesign) { ?>
			<li><a data-menu-action="edit-area-design" href="#"><?php echo t("Edit Area Design")?></a></li>
		<?php } ?>
		<?php if ($showAreaLayouts) {
			$areabt = BlockType::getByHandle(BLOCK_HANDLE_LAYOUT_PROXY);
		 ?>
			<?php $areaLayoutBT = BlockType::getByHandle('core_area_layout'); ?>

			<li><a dialog-title="<?php echo t('Add Layout')?>" data-block-type-handle="<?php echo $areabt->getBlockTypeHandle() ?>" data-area-grid-maximum-columns="<?php echo $a->getAreaGridMaximumColumns()?>" data-menu-action="add-inline" href="#" data-block-type-id="<?php echo $areabt->getBlockTypeID()?>"><?php echo t("Add Layout")?></a></li>
		<?php } ?>
		<?php if ($canEditAreaPermissions) { ?>
			<li class="divider"></li>
		<?php } ?>
	<?php } ?>

	<?php if ($canEditAreaPermissions) { ?>
		<li><a dialog-title="<?php echo t('Area Permissions')?>" class="dialog-launch" dialog-modal="false" dialog-width="425" dialog-height="430" id="menuAreaStyle<?php echo $a->getAreaID()?>" href="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/edit_area_popup?cID=<?php echo $c->getCollectionID()?>&arHandle=<?php echo urlencode($a->getAreaHandle())?>&atask=groups"><?php echo t("Permissions")?></a></li>
	<?php } ?>

	<?php
	if ($a instanceof SubArea) {
		$pk = PermissionKey::getByHandle('manage_layout_presets');
		if (!is_object($areabt)) {
			$areabt = BlockType::getByHandle(BLOCK_HANDLE_LAYOUT_PROXY);
		}
		$ax = $a->getSubAreaParentPermissionsObject();
		$axp = new Permissions($ax);
		if ($axp->canAddBlockToArea($bt)) {
			$bx = $a->getSubAreaBlockObject();
			if (is_object($bx) && !$bx->isError()) { ?>
				<li class="divider"></li>
				<li><a href="javascript:void(0)" data-container-layout-block-id="<?php echo $bx->getBlockID()?>" data-menu-action="edit-container-layout" data-area-grid-maximum-columns="<?php echo $a->getAreaGridMaximumColumns()?>"><?php echo t("Edit Container Layout")?></a></li>
				<?php if ($pk->validate()) {
					$btc = $bx->getController();
					$arLayout = $btc->getAreaLayoutObject(); ?>
					<li><a class="dialog-launch" href="<?php echo URL::to('/ccm/system/dialogs/area/layout/presets', $arLayout->getAreaLayoutID())?>" dialog-title="<?php echo t('Save Layout as Preset')?>" dialog-width="360" dialog-height="300" dialog-modal="true"><?php echo t("Save Layout as Preset")?></a></li>
                    <li><a class="dialog-launch" href="<?php echo URL::to('/ccm/system/dialogs/area/layout/presets/manage')?>" dialog-title="<?php echo t('Manage Presets')?>" dialog-width="360" dialog-height="240" dialog-modal="true"><?php echo t("Manage Presets")?></a></li>
				<?php } ?>
			<?php } ?>
		<?php }
	} ?>
	</ul>
	</div>
</div>
</div>
</div>
