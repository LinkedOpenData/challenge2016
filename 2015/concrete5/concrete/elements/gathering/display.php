<?php defined('C5_EXECUTE') or die("Access Denied.");

$items = $list->getPage();
$paginator = $list->getPagination();

if (!is_object($c)) {
  $c = Page::getCurrentPage();
}

$pt = $c->getCollectionThemeObject();
$agp = new Permissions($gathering);
if ($showTileControls && $agp->canEditGatheringItems()) {
  $showTileControls = true;
} else {
  $showTileControls = false;
}

?>

<div class="ccm-gathering-wrapper">

<div data-gathering-id="<?php echo $gathering->getGatheringID()?>" data-gathering-current-page="1" class="<?php if ($showTileControls) { ?>ccm-gathering-edit<?php } else { ?>ccm-gathering-view<?php } ?> ccm-gathering-grid">
    <?php foreach($items as $item) { ?>
      <?php echo Loader::element('gathering/tile', array('item' => $item, 'showTileControls' => $showTileControls))?>
    <?php } ?>
</div>

<div class="ccm-gathering-load-more">
  <button class="btn-large btn" data-gathering-button="gathering-load-more-items"><?php echo t('Load More')?></button>
</div>

</div>

<script type="text/javascript">
$(function() {
  $('div[data-gathering-id=<?php echo $gathering->getGatheringID()?>]').ccmgathering({
    totalPages: '<?php echo $paginator->getTotalPages()?>',
    'itemsPerPage': '<?php echo $itemsPerPage?>', 
    'gutter': <?php echo $pt->getThemeGatheringGridItemMargin()?>,
    columnWidth: <?php echo $pt->getThemeGatheringGridItemWidth()?>,
    rowHeight: <?php echo $pt->getThemeGatheringGridItemHeight()?>,
    gaID: <?php echo $gathering->getGatheringID()?>,
    showTileControls: '<?php echo $showTileControls?>',
    loadToken: '<?php echo Loader::helper('validation/token')->generate('get_gathering_items')?>',
    editToken: '<?php echo Loader::helper('validation/token')->generate('update_gathering_items')?>',
    titleEditTemplate: '<?php echo t('Edit Gathering Template')?>'
  });
});
</script>

<style type="text/css">
<?php for ($i = 1; $i <= 8; $i++) { ?>
  div.w<?php echo $i?> {
    width: <?php echo (($i * $pt->getThemeGatheringGridItemWidth()) + ($pt->getThemeGatheringGridItemMargin() * ($i - 1)))?>px;
  }

  div.h<?php echo $i?> {
    height: <?php echo (($i * $pt->getThemeGatheringGridItemHeight()) + ($pt->getThemeGatheringGridItemMargin() * ($i - 1)))?>px;
  }
<?php } ?>
</style>
