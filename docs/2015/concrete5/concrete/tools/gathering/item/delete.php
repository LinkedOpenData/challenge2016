<?php defined('C5_EXECUTE') or die("Access Denied.");

$nh = Loader::helper('validation/numbers');
$form = Loader::helper('form');
$gaiID = intval($_REQUEST['gaiID']);

$nh = Loader::helper('validation/numbers');
$item = GatheringItem::getByID($gaiID);
if (is_object($item)) {
  $gathering = $item->getGatheringObject();
  $agp = new Permissions($gathering);
  if ($agp->canEditGatheringItems() && Loader::helper('validation/token')->validate('delete_gathering_item', $_REQUEST['token'])) {
    if ($_POST['task'] == 'delete_item') {
      $item->deactivate();
      exit;
    }
    ?>

    <div class="ccm-ui">
      <p><?php echo t('Are you sure you want to delete this tile?')?></p>
    </div>


    </form>

    <div class="dialog-buttons">
    <button class="btn pull-left btn-hover-danger" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
    <button class="btn pull-right btn-danger" onclick="$.fn.ccmgathering('deleteItem', {gaiID: '<?php echo $gaiID?>', 'deleteToken': '<?php echo Loader::helper('validation/token')->generate('delete_gathering_item')?>'})"><?php echo t('Delete')?></button>
    </div>

    <?php }

  }
?>
