<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div style="position: relative">

<div style="z-index: 4; opacity: 0.3; position: absolute; top: 0px; left: 0px; margin-left: -5px; margin-top: -15px; width: 1040px; height: 500px; background-image: url(<?php echo $image->getSrc()?>); background-repeat: no-repeat;"></div>

<div style="position: relative; color: #000; z-index: 5">
<h2><?php echo $title?></h2>
<h5><?php echo Core::make('helper/date')->formatDateTime($date_time, true)?></h5>
<p><?php echo $description?></p>
<a href="<?php echo $link?>" class="btn"><?php echo t("Read More")?></a>
</div>
</div>