<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="simple_circle">
	<div id="jquery_jplayer_<?php  echo $bID; ?>" class="jp-jplayer"></div>
	<div id="jp_container_<?php  echo $bID; ?>" class="jp-audio">
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
				<div class="jp-controls">
					<div class="jp-play"><i class="fa fa-play"></i></div>
					<div class="jp-stop"><i class="fa fa-stop"></i></div>
				</div>
			</div>
			<div class="jp-details">
				<ul><li><span class="jp-title"></span></li></ul>
			</div>
			<div class="jp-no-solution">
				<span><?php  echo t('Update Required'); ?></span>
				<?php  echo t('To play the media you will need to either update your browser to a recent version or update your'); ?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php  echo t('Flash plugin'); ?></a>.
			</div>
		</div>
	</div>
<?php 
$c = \Page::getCurrentPage();
if (!$c->isEditMode()):
?>
<script type="text/javascript">
    $(function () {
		var options = <?php  echo $options; ?>;
		var extensions = {
			ready: function (event) {
				$(this).jPlayer("setMedia", options.files);
				if (options.autoPlay) {
					$(this).jPlayer("play");
				}
			},
			play: function (event) {
				if (options.pauseOthers) {
					$(this).jPlayer("pauseOthers");
				}
				$("#jp_container_<?php  echo $bID; ?> .jp-controls .jp-play").hide();
				$("#jp_container_<?php  echo $bID; ?> .jp-controls .jp-stop").show();
			},
		    pause: function(event) {
		    	$("#jp_container_<?php  echo $bID; ?> .jp-controls .jp-play").show();
				$("#jp_container_<?php  echo $bID; ?> .jp-controls .jp-stop").hide();
	        },
	        ended: function(event) {
	        	$("#jp_container_<?php  echo $bID; ?> .jp-controls .jp-play").show();
				$("#jp_container_<?php  echo $bID; ?> .jp-controls .jp-stop").hide();
	        }
		}
		$.extend(options, extensions);

		$("#jquery_jplayer_<?php  echo $bID; ?>").jPlayer(options);
	});
</script>
<?php  endif; ?>
</div>
