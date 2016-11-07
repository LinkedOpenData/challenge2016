<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-gathering-overlay">
	<div class="ccm-gathering-overlay-title"><?php echo $title?></div>
	<?php if ($date_time) { ?>
		<div><?php echo Core::make('helper/date')->formatDateTime($date_time, true)?></div>
	<?php } ?>
	<?php if ($description) { ?>
		<p><?php echo $description?></p>
	<?php } ?>
</div>
