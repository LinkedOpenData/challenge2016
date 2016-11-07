<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php 
if (!$bObj->aspectW) {
	$bObj->aspectW=16;
}
if (!$bObj->aspectH) {
	$bObj->aspectH=9;
}
?>
<style>
    .ccm-ui .form-control.re-dims {
        width: 100px;
		display: inline;
    }
	.ccm-ui label {
		display: block;
	}
		
</style>
<div class="form-group">
    <label><?php  echo t('IFrame source URL')?></label>
    <input type="text" class="form-control" id="REmbedSrcURL" name="srcURL" value="<?php  echo $bObj->srcURL?>" />
</div>
<div class="form-group">
    <label><?php  echo t('Aspect ratio')?></label>
    <input type="text" class="form-control re-dims" id="REmbedAspectW" name="aspectW" value="<?php  echo $bObj->aspectW?>" />
	:
    <input type="text" class="form-control re-dims" id="REmbedAspectH" name="aspectH" value="<?php  echo $bObj->aspectH?>" />
</div>
<div class="form-group">
    <label><?php  echo t('Chrome height')?></label>
    <input type="text" class="form-control re-dims" id="REmbedChromeH" name="cHeight" value="<?php  echo $bObj->cHeight?>" /> px
</div>
