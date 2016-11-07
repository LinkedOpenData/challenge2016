<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
$ap = new Permissions($item->getGatheringObject());
$type = GatheringItemTemplateType::getByHandle('tile');
$types = GatheringItemTemplateType::getList();
if ($item->canViewGatheringItem()) { ?>

<div data-block-type-handle="<?php echo BLOCK_HANDLE_GATHERING_ITEM_PROXY?>" data-gathering-item-batch-timestamp="<?php echo $item->getGatheringItemBatchTimestamp()?>" data-gathering-item-id="<?php echo $item->getGatheringItemID()?>" class="ccm-gathering-item h<?php echo $item->getGatheringItemSlotHeight()?> w<?php echo $item->getGatheringItemSlotWidth()?>">
  <div class="ccm-gathering-item-inner">
  <?php if ($showTileControls && $ap->canEditGatheringItems()) { ?>
  <div class="ccm-ui">
    <ul class="ccm-gathering-item-inline-commands ccm-ui">
      <li class="ccm-gathering-item-inline-move"><a data-inline-command="move-tile" href="#"><i class="fa fa-arrows"></i></a></li>
      <li class="ccm-gathering-item-inline-options"><a data-inline-command="options-tile" href="#" data-launch-menu="gathering-menu-<?php echo $item->getGatheringItemID()?>"><i class="fa fa-cog"></i></a></li>
    </ul>

    <div class="popover fade" data-menu="gathering-menu-<?php echo $item->getGatheringItemID()?>">
      <div class="arrow"></div>
      <div class="popover-inner">
      <ul class="dropdown-menu">
        <?php foreach($types as $t) { ?>
          <li><a href="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/gathering/item/template?gaiID=<?php echo $item->getGatheringItemID()?>&gatTypeID=<?php echo $t->getGatheringItemTemplateTypeID()?>&token=<?php echo Loader::helper('validation/token')->generate('edit_gathering_item_template')?>" class="dialog-launch" dialog-title="<?php echo t('Edit %s Template', $t->getGatheringItemTemplateTypeName())?>" dialog-width="660" dialog-height="430" ><?php echo t('Edit %s Template', $t->getGatheringItemTemplateTypeName())?></a></li>
        <?php } ?>
          <li class="divider"></li>
          <li><a href="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/gathering/item/delete?gaiID=<?php echo $item->getGatheringItemID()?>&token=<?php echo Loader::helper('validation/token')->generate('delete_gathering_item')?>" class="dialog-launch" dialog-title="<?php echo t('Delete Item')?>" dialog-width="320" dialog-height="160"><?php echo t('Delete Tile')?></a></li>
      </ul>
      </div>
    </div>
  </div>

  <?php } ?>

  <div class="ccm-gathering-item-inner-render">
	  <?php $item->render($type); ?>
	</div>
</div>
</div>
<?php } ?>
