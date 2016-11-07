<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	$this->inc('form.php', array('b' => $b, 'a' => $a));

?>

<input type="hidden" name="arLayoutID" value="<?php echo $controller->arLayout->getAreaLayoutID()?>" />

<div id="ccm-layouts-edit-mode" class="ccm-layouts-edit-mode-edit">

<?php echo $themeGridFramework->getPageThemeGridFrameworkRowStartHTML()?>

<div id="ccm-theme-grid-edit-mode-row-wrapper">

<?php foreach($columns as $col) { ?>
	<?php $i = $col->getAreaLayoutColumnIndex(); ?>
	<?php if ($col->getAreaLayoutColumnOffset() > 0) { ?>
		<div class="<?php echo $col->getAreaLayoutColumnOffsetEditClass()?> ccm-theme-grid-offset-column">&nbsp;</div>
	<?php } ?>

	<div class="<?php echo $col->getAreaLayoutColumnClass()?> ccm-theme-grid-column ccm-theme-grid-column-edit-mode" id="ccm-edit-layout-column-<?php echo $i?>" data-offset="<?php echo $col->getAreaLayoutColumnOffset()?>" data-span="<?php echo $col->getAreaLayoutColumnSpan()?>">
		<div class="ccm-layout-column-inner ccm-layout-column-highlight">
			<input type="hidden" name="span[<?php echo $i?>]" value="<?php echo $col->getAreaLayoutColumnSpan()?>" id="ccm-edit-layout-column-span-<?php echo $i?>" />
			<input type="hidden" name="offset[<?php echo $i?>]" value="<?php echo $col->getAreaLayoutColumnOffset()?>" id="ccm-edit-layout-column-offset-<?php echo $i?>" />
			<?php 
			$col->display(true);
			?>
		</div>
	</div>
<?php } ?>

</div>

<?php echo $themeGridFramework->getPageThemeGridFrameworkRowEndHTML()?>

</div>