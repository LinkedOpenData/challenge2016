<?php 
defined('C5_EXECUTE') or die("Access Denied.");

$url       = parse_url($videoURL);
$pathParts = explode('/', rtrim($url['path'], '/'));
$videoID   = end($pathParts);

if (isset($url['query'])) {
	parse_str($url['query'], $query);
	$videoID = (isset($query['v'])) ? $query['v'] : $videoID;
}

$vWidth  = ($vWidth)  ? $vWidth  : 425;
$vHeight = ($vHeight) ? $vHeight : 344;
$chromeHeight=35;
$aspectRatio=($vHeight>$chromeHeight)?$vWidth/($vHeight-$chromeHeight):100;
$paddingPct=100/$aspectRatio;
$style="padding-bottom: $paddingPct%;";

if (Page::getCurrentPage()->isEditMode()) { ?>

	<div class="ccm-edit-mode-disabled-item youtubeBlock responsive" style="<?php  echo $style; ?>">
		<div style="padding:8px 0px; padding-top: <?php  echo ($paddingPct/2.5)?>%;"><?php  echo t('YouTube Video disabled in edit mode.'); ?></div>
	</div>
	
<?php  } elseif ($vPlayer == 1) { ?>

	<div id="youtube<?php  echo $bID; ?>" class="youtubeBlock responsive" style="<?php  echo $style; ?>">
		<iframe class="youtube-player" src="//www.youtube.com/embed/<?php  echo $videoID; ?>?wmode=transparent" frameborder="0" allowfullscreen></iframe>
	</div>
	
<?php  } else { ?>

	<div id="youtube<?php  echo $bID; ?>" class="youtubeBlock responsive" style="<?php  echo $style; ?>"><div id="youtube<?php  echo $bID; ?>_video"><?php  echo t('You must install Adobe Flash to view this content.'); ?></div></div>
	<script type="text/javascript">
	//<![CDATA[
	params = {
		wmode: "transparent"
	};
	flashvars = {};
	swfobject.embedSWF('//www.youtube.com/v/<?php  echo $videoID; ?>', 'youtube<?php  echo $bID; ?>_video', '<?php  echo $vWidth; ?>', '<?php  echo $vHeight; ?>', '8.0.0', false, flashvars, params);
	//]]>
	</script>
	
<?php  } ?>
