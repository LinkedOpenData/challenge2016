<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
$ih = Loader::helper("image");
$img = File::getByID($fID);
if(is_object($img)){
    $thumb = $ih->getThumbnail($img,$maxThumbWidth,$maxThumbHeight,true);	
    $large = $ih->getThumbnail($img,$maxImageWidth,$maxImageHeight,false);
}
$c = Page::getCurrentPage();
?>

<?php  if($zoomType=="zoom"){ ?>
<?php  if (!$c->isEditMode()) { ?>
<script type="text/javascript">
$(function(){
	$("#zoomer-<?php echo $bID?>").elevateZoom();
});
</script>
<?php  } ?>
<img src="<?php echo $thumb->src?>" id="zoomer-<?php echo $bID?>" data-zoom-image="<?php echo $large->src?>">
<?php  } 

else if($zoomType=="innerzoom"){ ?>
<?php  if (!$c->isEditMode()) { ?>
<script type="text/javascript">
$(function(){
	$("#zoomer-<?php echo $bID?>").elevateZoom({
		zoomType: "inner", 
		cursor: "crosshair"
	});
});
</script>
<?php  } ?>
<img src="<?php echo $thumb->src?>" id="zoomer-<?php echo $bID?>" data-zoom-image="<?php echo $large->src?>">
<?php  }

else if($zoomType=="lenszoom"){ ?>
<?php  if (!$c->isEditMode()) { ?>
<script type="text/javascript">
$(function(){
	$("#zoomer-<?php echo $bID?>").elevateZoom({
		zoomType: "lens", 
		lensShape: "round", 
		lensSize : 100 
	});
});
</script>
<?php  } ?>
<img src="<?php echo $thumb->src?>" id="zoomer-<?php echo $bID?>" data-zoom-image="<?php echo $large->src?>">
<?php  } 

else if($zoomType=="lightbox"){ ?>
<a href="<?php echo $large->src?>" data-featherlight="image">
<img src="<?php echo $thumb->src?>" id="zoomer-<?php echo $bID?>">
</a>
<?php  } ?>