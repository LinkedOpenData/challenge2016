<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	$a = $b->getBlockAreaObject();
?>

<?php echo $gf->getPageThemeGridFrameworkRowStartHTML()?>

<?php foreach($columns as $col) { ?>
	<?php if ($col->getAreaLayoutColumnOffset() > 0 && (!$gf->hasPageThemeGridFrameworkOffsetClasses())) { ?>
		<div class="<?php echo $col->getAreaLayoutColumnOffsetClass()?> ccm-theme-grid-offset-column"></div>
	<?php } ?>
	<div class="<?php echo $col->getAreaLayoutColumnClass()?><?php if ($gf->hasPageThemeGridFrameworkOffsetClasses() && $col->getAreaLayoutColumnOffset()) { ?> <?php echo $col->getAreaLayoutColumnOffsetClass()?><?php } ?>"><?php 
		$col->display();
	?></div>

<?php } ?>

<?php echo $gf->getPageThemeGridFrameworkRowEndHTML()?>