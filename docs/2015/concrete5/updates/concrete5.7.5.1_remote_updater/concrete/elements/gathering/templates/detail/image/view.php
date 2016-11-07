<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
if (is_array($image)) {
	$image = $image[0];
}
?>

<div class="ccm-gathering-overlay">
	<img src="<?php echo $image->getSrc()?>" style="max-width: 600px" />
	<div class="ccm-gathering-thumbnail-caption"><?php echo $title?></div>
</div>
