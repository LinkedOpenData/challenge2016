<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	$this->inc('form.php', array('b' => $b, 'a' => $a));

?>

<input type="hidden" name="arLayoutID" value="<?php echo $controller->arLayout->getAreaLayoutID()?>" />

<div id="ccm-layouts-edit-mode" class="ccm-layouts-edit-mode-edit">

<?php foreach($columns as $col) { ?>
	<?php $i = $col->getAreaLayoutColumnIndex(); ?>
	<div class="<?php echo $col->getAreaLayoutColumnClass()?>" id="ccm-edit-layout-column-<?php echo $i?>" <?php if ($iscustom) { ?>data-width="<?php echo $col->getAreaLayoutColumnWidth()?>" <?php } ?>>
		<div class="ccm-layout-column-inner ccm-layout-column-highlight">
			<input type="hidden" name="width[<?php echo $i?>]" value="" id="ccm-edit-layout-column-width-<?php echo $i?>" />
			<?php 
			$col->display(true);
			?>
		</div>
	</div>
<?php } ?>

</div>