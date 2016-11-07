<?php   defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');


if ($pdf_file) {
	$file = File::getByID($pdf_file);
}else{
	$pdf_file = 0; 
}

?>

<style type="text/css" media="screen">
.ccm-block-field-group h2 { margin-bottom: 5px;font-size:1.6em }
.ccm-block-field-group td { vertical-align: middle; }
</style>

<div class="ccm-block-field-group">
	<h2><?php  echo t("PDF File"); ?></h2>
	<?php   echo $al->file('pdf_file', 'pdf_file', 'Choose File', $file); ?>
</div>

<div class="ccm-block-field-group">
	<h2><?php  echo t("External URL"); ?></h2>
	<?php   echo $form->text('external_url', $external_url, array('style' => 'width: 100%;')); ?>
</div>
<div class="ccm-block-field-group">
	<h2><?php  echo t("Width"); ?></h2>
	<table>
		<tbody>
			<tr>
				<td><?php   echo $form->number('width', $width, array('style' => 'width: 80px;')); ?></td>
				<td><?php   echo $form->select('width_size', array("px" => "px", "%" => "%", "em" => "em"), $width_size); ?></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="ccm-block-field-group">
	<h2><?php  echo t("Height"); ?></h2>
	<table>
		<tbody>
			<tr>
				<td><?php   echo $form->text('height', $height, array('style' => 'width: 80px;')); ?></td>
				<td><?php   echo $form->select('height_size', array("px" => "px", "%" => "%", "em" => "em"), $height_size); ?></td>
			</tr>
		</tbody>
	</table>
</div>