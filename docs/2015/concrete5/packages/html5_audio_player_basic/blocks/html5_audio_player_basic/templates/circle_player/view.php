<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$c = \Page::getCurrentPage();

if ($c->isEditMode()): ?>
	<div class="ccm-edit-mode-disabled-item" style="width:200px;height:200px;">
		<div style="padding:20px"><?php  echo t('Audio player disabled in edit mode.')?></div>
	</div>
<?php  else:	?>
<div class="circle_player">
	<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
	<div id="jquery_jplayer_<?php  echo $bID; ?>" class="cp-jplayer"></div>

	<!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->
	<div id="cp_container_<?php  echo $bID; ?>" class="cp-container">
		<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
			<div class="cp-buffer-1"></div>
			<div class="cp-buffer-2"></div>
		</div>
		<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
			<div class="cp-progress-1"></div>
			<div class="cp-progress-2"></div>
		</div>
		<div class="cp-circle-control"></div>
		<ul class="cp-controls">
			<li><a class="cp-play" tabindex="1"><?php  echo t('play'); ?></a></li>
			<li><a class="cp-pause" style="display:none;" tabindex="1"><?php  echo t('pause'); ?></a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
		</ul>
		<div class="jp-details">
			<ul><li><span class="jp-title"></span></li></ul>
		</div>
	</div>
<script type="text/javascript">
$(function () {
	var options = <?php  echo $options; ?>;
	$.extend(options, { cssSelectorAncestor: '#cp_container_<?php  echo $bID; ?>' })
	var cp = new CirclePlayer(
		'#jquery_jplayer_<?php  echo $bID; ?>',
		options.files,
		options
	);
});
</script>
</div>
<?php  endif; ?>
