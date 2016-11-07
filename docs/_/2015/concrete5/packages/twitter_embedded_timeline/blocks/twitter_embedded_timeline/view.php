<?php   defined('C5_EXECUTE') or die("Access Denied."); ?>

<a
class="twitter-timeline"
href="<?php  if ($profileAddress) { echo $profileAddress; } ?>"
data-widget-id="<?php  if ($widgetID) { echo $widgetID; } ?>"

data-chrome="<?php 
if ($transparentBackground == 'transparent') {
    echo $transparentBackground . ' ';
}
if ($widgetHeader == 'noheader') {
    echo $widgetHeader . ' ';
}
if ($widgetBorder == 'noborders') {
    echo $widgetBorder . ' ';
}
if ($widgetScrollbar == 'noscrollbar') {
    echo $widgetScrollbar . ' ';
}
if ($widgetFooter == 'nofooter') {
    echo $widgetFooter;
}
?>"

data-tweet-limit="<?php  if ($tweetsDisplayed) { echo $tweetsDisplayed; } ?>"
data-theme="<?php  if ($widgetTheme) { echo $widgetTheme; } ?>"
data-link-color="<?php  if ($linkColor) { echo $linkColor; } ?>"
data-border-color="<?php  if ($borderColor) { echo $borderColor; } ?>"
height="<?php  if ($height) { echo $height; } ?>"
width="<?php  if ($width) { echo $width; } ?>"
>
Tweets by @<?php  if ($profileName) { echo $profileName; } ?>
</a>

<script src="https://platform.twitter.com/widgets.js"></script>