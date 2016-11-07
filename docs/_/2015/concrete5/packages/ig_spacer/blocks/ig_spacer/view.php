<?php    defined('C5_EXECUTE') or die(_("Access Denied."));
if (preg_match('/em|px|%/', $spacerHeight)) {
	$height = $spacerHeight;
} else {
	$height = $spacerHeight.'px';
}
?>
<div class="igSpacer" style="height:<?php    echo $height;?>"></div>
