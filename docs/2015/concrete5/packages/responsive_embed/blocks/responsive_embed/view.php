<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$aspectW  = ($aspectW)  ? $aspectW  : 16;
$aspectH = ($aspectH) ? $aspectH : 9;
$cHeight = ($cHeight) ? $cHeight : 0;
$aspectRatio = ($aspectH>0) ? $aspectW/$aspectH : 100;
$paddingPct=100/$aspectRatio;
$style="padding-bottom: $paddingPct%; padding-top: ${cHeight}px";

if (Page::getCurrentPage()->isEditMode()) { ?>

	<div class="ccm-edit-mode-disabled-item responsive_embed" style="<?php  echo $style ?>">
		<div class='re-edit-notice' style="position: absolute; top: 45%; left: 0; width: 100%"><?php  echo t('External content disabled in edit mode.'); ?></div>
	</div>
	
<?php  } else { ?>

	<div id="responsive_embed_<?php  echo $bID; ?>" class="responsive_embed" style="<?php  echo $style ?>">
		<iframe src="<?php  echo $srcURL; ?>" mozallowfullscreen webkitAllowFullScreen allowFullScreen></iframe>
	</div>
	
<?php  } ?>
