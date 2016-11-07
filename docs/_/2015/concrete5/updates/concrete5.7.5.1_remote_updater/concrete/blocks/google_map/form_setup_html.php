<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-google-map-block-container row">
    <div class="col-xs-12">
        <div class="form-group">
            <?php echo $form->label('title', t('Map Title (optional)'));?>
            <?php echo $form->text('title', $mapObj->title);?>
        </div>

        <div id="ccm-google-map-block-location" class="form-group">
            <?php echo $form->label('location', t('Location'));?>
            <?php echo $form->text('location', $mapObj->location);?>
            <?php echo $form->hidden('latitude', $mapObj->latitude);?>
            <?php echo $form->hidden('longitude', $mapObj->longitude);?>
            <div id="block_note" class="note"><?php echo t('Start typing a location (e.g. Apple Store or 235 W 3rd, New York) then click on the correct entry on the list.')?></div>
            <div id="map-canvas"></div>	
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <?php echo $form->label('zoom', t('Zoom'));?>
            <?php
                $zoomArray = array();
                for($i=0;$i<=21;$i++) {
                    $zoomArray[$i] = $i;
                }
            ?>
            <?php echo $form->select('zoom', $zoomArray, $mapObj->zoom);?>
        </div>
    </div>

    <div class="col-xs-4">	
        <div class="form-group"> 
            <?php echo $form->label('width', t('Map Width'));?>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
                <?php if(is_null($width) || $width == 0) {$width = '100%';};?>
                <?php echo $form->text('width', $width);?>
            </div>
        </div>
    </div>

    <div class="col-xs-4">
        <div class="form-group">
            <?php echo $form->label('height', t('Map Height'));?>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
                <?php if(is_null($height) || $height == 0) {$height = '400px';};?>
                <?php echo $form->text('height', $height); ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
          <label>
            <?php echo $form->checkbox('scrollwheel', 1, (is_null($scrollwheel) || $scrollwheel)); ?>
            <?php echo t("Enable Scroll Wheel")?>
          </label>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    window.C5GMaps.init();
});
</script>