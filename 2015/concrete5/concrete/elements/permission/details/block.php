<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = $b->getBlockCollectionObject();
$arHandle = $b->getAreaHandle();
$pk = PermissionKey::getByID($_REQUEST['pkID']);
$pk->setPermissionObject($b);
?>

<?php Loader::element("permission/detail", array('permissionKey' => $pk)); ?>


<script type="text/javascript">
var ccm_permissionDialogURL = '<?php echo URL::to('/ccm/system/dialogs/block/permissions/detail')?>?bID=<?php echo $b->getBlockID()?>&arHandle=<?php echo urlencode($b->getAreaHandle())?>&cvID=<?php echo $c->getVersionID()?>&bID=<?php echo $b->getBlockID()?>&cID=<?php echo $c->getCollectionID()?>';
</script>