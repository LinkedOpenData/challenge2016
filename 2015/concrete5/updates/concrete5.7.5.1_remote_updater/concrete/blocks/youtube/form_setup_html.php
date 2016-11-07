<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
if (!$bObj->vWidth) {
	$bObj->vWidth=425;
}
if (!$bObj->vHeight) {
	$bObj->vHeight=344;
}
?>
<style>
    .ccm-ui .form-control.yt-vid-dims {
        width: 100px;
    }
</style>
<div class="form-group">
    <label><?php echo t('Title')?></label>
    <input type="text" class="form-control" name="title" value="<?php echo $bObj->title?>"/>
</div>
<div class="form-group">
    <label><?php echo t('YouTube URL')?></label>
    <input type="text" class="form-control" id="YouTubeVideoURL" name="videoURL" value="<?php echo $bObj->videoURL?>" />
</div>
<div class="form-group">
    <label><?php echo t('Width')?></label>
    <input type="text" class="form-control yt-vid-dims" id="YouTubeVideoWidth" name="vWidth" value="<?php echo $bObj->vWidth?>" />
</div>
<div class="form-group">
    <label><?php echo t('Height')?></label>
    <input type="text" class="form-control yt-vid-dims" id="YouTubeVideoHeight" name="vHeight" value="<?php echo $bObj->vHeight?>" />
</div>
<div class="form-group">
    <label><?php echo t('Video Player')?></label>
        <div class="radio">
            <label><input type="radio" name="vPlayer" value="1" <?php echo ($bObj->vPlayer)?'checked':''?> /> <?php echo t('iFrame - Works in more devices')?></label>
        </div>
    <div class="radio">
        <label>
            <input type="radio" name="vPlayer" value="0" <?php echo (!$bObj->vPlayer)?'checked':''?> /> <?php echo t('Flash Embed - Legacy method')?>
        </label>
    </div>
</div>
