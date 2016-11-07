<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
$al = Loader::helper('concrete/asset_library');
?>
<div class="form-group">
	<?php  echo $form->label("ccm-b-image",t("Select Image")); ?>
	<div class="input">
		<?php 
		if($fID){
			echo $al->image('ccm-b-image', 'fID', t('Choose Image'), ($fID)?File::getByID($fID):"");
		}
		else{
			echo $al->image('ccm-b-image', 'fID', t('Choose Image'));
		}
		?>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<?php  echo $form->label("zoomType", t("Zoom Type")); ?>
			<?php  echo $form->select("zoomType", array("zoom"=>"Zoom", "innerzoom"=>"Inner Zoom", "lenszoom"=>"Lens Zoom", "lightbox"=>"Lightbox"), $zoomType); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<?php  echo $form->label("maxThumbWidth",t("Max Thumbnail Width"));?>
			<div class="input-group">
				<?php  echo $form->text("maxThumbWidth",$maxThumbWidth?$maxThumbWidth:"120"); ?>
				<div class="input-group-addon">px</div>
			</div>
		</div>
		<div class="form-group">
			<?php  echo $form->label("maxImageWidth",t("Max Image Width"));?>
			<div class="input-group">
				<?php  echo $form->text("maxImageWidth",$maxImageWidth?$maxImageWidth:"1000"); ?>
				<div class="input-group-addon">px</div>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group">
			<?php  echo $form->label("maxThumbHeight",t("Max Thumbnail Height"));?>
			<div class="input-group">
				<?php  echo $form->text("maxThumbHeight",$maxThumbHeight?$maxThumbHeight:"80"); ?>
				<div class="input-group-addon">px</div>
			</div>
		</div>
		<div class="form-group">
			<?php  echo $form->label("maxImageHeight",t("Max Image Height"));?>
			<div class="input-group">
				<?php  echo $form->text("maxImageHeight",$maxImageHeight?$maxImageHeight:"800"); ?>
				<div class="input-group-addon">px</div>
			</div>
		</div>
	</div>
</div>