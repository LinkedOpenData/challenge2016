<?php 
defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="bootstrap-player">
	<div id="jquery_jplayer_<?php  echo $bID; ?>" class="jp-jplayer"></div>
	<div id="jp_container_<?php  echo $bID; ?>" class="jp-audio">
		<div class="jp-album-art"></div>
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
				<div class="jp-controls">
					<a href="javascript:;" class="jp-play" tabindex="1"><i class="fa fa-play"></i></a>
					<a href="javascript:;" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i></a>
					<a href="javascript:;" class="jp-stop" tabindex="1"><i class="fa fa-stop"></i></a>
					<a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fa fa-volume-down"></i></a>
					<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fa fa-volume-off"></i></a>
					<a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><i class="fa fa-volume-up"></i></a>
				</div>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
				<div class="jp-time-holder">
					<div class="jp-time-wrapper">
						<div class="jp-current-time"></div>
					</div>
				</div>
				<div class="jp-toggles">
					<a href="javascript:;" class="jp-repeat" tabindex="1"><i class="fa fa-repeat"></i></a>
					<a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><i class="fa fa-repeat"></i></a>
				</div>
			</div>
			<div class="jp-details">
				<ul>
					<li><span class="jp-title"></span></li>
				</ul>
			</div>
			<div class="jp-no-solution">
				<span><?php  echo t('Update Required'); ?></span>
				<?php  echo t('To play the media you will need to either update your browser to a recent version or update your'); ?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php  echo t('Flash plugin'); ?></a>.
			</div>
		</div>
	</div>
<?php 
	$c = \Page::getCurrentPage();
	if (!$c->isEditMode()): ?>
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
				$("#jp_container_<?php  echo $bID; ?> .jp-current-time").fadeIn();
			},
		    pause: function(event) {
		    	$("#jp_container_<?php  echo $bID; ?> .jp-current-time").fadeOut();
	        },
	        ended: function(event) {
	        	$("#jp_container_<?php  echo $bID; ?> .jp-current-time").hide();
	        },
	        timeupdate: function(event) {
	        	$("#jp_container_<?php  echo $bID; ?> .jp-time-wrapper").css('left', event.jPlayer.status.currentPercentAbsolute+'%');
	        }
		}
		$.extend(options, extensions);

		$("#jquery_jplayer_<?php  echo $bID; ?>").jPlayer(options);
	});
</script>
<?php  endif; ?>
</div>

