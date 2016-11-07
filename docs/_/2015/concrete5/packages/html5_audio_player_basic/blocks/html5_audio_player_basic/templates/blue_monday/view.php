<?php  defined('C5_EXECUTE') or die("Access Denied.");

$c = \Page::getCurrentPage();

if ($c->isEditMode()): ?>
	<div class="ccm-edit-mode-disabled-item" style="width:420px;height:100px;">
		<div style="padding:20px"><?php  echo t('Blue Monday player disabled in edit mode.'); ?></div>
	</div>
<?php  else: ?>
<div class="blue_monday">
	<div id="jquery_jplayer_<?php  echo $bID; ?>" class="jp-jplayer"></div>
	<div id="jp_container_<?php  echo $bID; ?>" class="jp-audio">
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
				<ul class="jp-controls">
					<li><a href="javascript:;" class="jp-play" tabindex="1"><?php  echo t('play'); ?></a></li>
					<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php  echo t('pause'); ?></a></li>
					<li><a href="javascript:;" class="jp-stop" tabindex="1"><?php  echo t('stop'); ?></a></li>
					<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><?php  echo t('mute'); ?></a></li>
					<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><?php  echo t('unmute'); ?></a></li>
					<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><?php  echo t('max volume'); ?></a></li>
				</ul>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
				<div class="jp-time-holder">
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php  echo t('repeat'); ?></a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php  echo t('repeat off'); ?></a></li>
					</ul>
				</div>

			</div>
			<div class="jp-details">
				<ul>
					<li>
						<span class="jp-title"></span>
					</li>
				</ul>
			</div>
			<div class="jp-no-solution">
				<span><?php  echo t('Update Required'); ?></span>
				<?php  echo t('To play the media you will need to either update your browser to a recent version or update your'); ?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php  echo t('Flash plugin'); ?></a>.
			</div>
		</div>
	</div>
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
			}
		}
		$.extend(options, extensions);

		$("#jquery_jplayer_<?php  echo $bID; ?>").jPlayer(options);
	});
</script>
</div>
<?php  endif; ?>
