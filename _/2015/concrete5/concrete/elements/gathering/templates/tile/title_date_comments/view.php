<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-gathering-tile-headline"><a href="<?php echo $link?>"><?php echo $title?></a></div>
<div><?php echo Core::make('helper/date')->formatDateTime($date_time, true)?></div>

<div>
<br/>
<i class="icon-bullhorn"></i> <?php echo $totalPosts?>
</div>



