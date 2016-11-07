<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>


<div class="ccm-ui">
<div id="ccm-dialog-attributes-menu"><?php echo $menu->render()?></div>
<div id="ccm-dialog-attributes-detail">
	<p class="lead"><?php echo t('Selected Attributes')?></p>
	<?php echo $detail->render()?></div>
</div>