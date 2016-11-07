<?php   defined('C5_EXECUTE') or die("Access Denied.");

$urlHelper = Core::make('helper/concrete/urls');
$blockType = BlockType::getByHandle('svg_social_media_icons');
$localPath = $urlHelper->getBlockTypeAssetsURL($blockType);

// Example: $localPath
// /concrete5/packages/svg_social_media_icons/blocks/svg_social_media_icons
?>

<?php 
// Example: $sortOrder
// "Flickr,deviantART,Email,Behance,Dribbble,Facebook,Github,GooglePlus,Instagram,iTunes,Linkedin,Pinterest,Skype,SoundCloud,Spotify,Tumblr,Twitter,Vimeo,Youtube"

 // split the $sortOrder string using "," and return the substrings as an array
$sortOrderArray = explode(',', $sortOrder);

// Example: $sortOrderArray
// Array
// (
//     [0] => Flickr
//     [1] => deviantART
//     [2] => Email
//     [3] => Behance
//     [4] => Dribbble
//     [5] => Facebook
//     [6] => Github
//     [7] => GooglePlus
//     [8] => Instagram
//     [9] => iTunes
//     [10] => Linkedin
//     [11] => Pinterest
//     [12] => Skype
//     [13] => SoundCloud
//     [14] => Spotify
//     [15] => Tumblr
//     [16] => Twitter
//     [17] => Vimeo
//     [18] => Youtube
// )
?>

<?php 
$iconList[] = '';

//                          Flickr
foreach ($sortOrderArray as $iconOrder) {
    // flickr
    $lower_case_name = strtolower($iconOrder);

    // 'flickr' => array(
    //         'checked' => 'flickr',
    //         'address' => 'https://www.flickr.com/photos/your-account-name'
    //         )
    // if the icon is checked, add it to the $iconList array
    if ($icon[$lower_case_name]['checked']) {
        // array(0 => 'flickr', 1 => 'https://www.flickr.com/photos/your-account-name')
        $iconList[] = array($lower_case_name, $icon[$lower_case_name]['address']);
    }
}
?>

<style>
.ccm-block-svg_social_media_icons .icon-container {
    <?php 
    if ($position) {
        echo 'float: right;';
    }
    ?>

    padding-top: 5px;
    padding-bottom: 5px;
}
.ccm-block-svg_social_media_icons .icon-container a:first-child {
    margin-left: 0 !important;
}
</style>

<div class="ccm-block-svg_social_media_icons">
    <div class="icon-container">

    <?php 
    foreach ($iconList as $value) {
        if ($value[0]) {
            // create the CSS for the icon background
            $css = '.' . $value[0] . $iconSize . '-' . $iconShape . '-' . $iconColor
                       . "{background:url('" . $localPath . "/images/" . $value[0] . $iconSize . '-' . $iconShape . '-' . $iconColor
                       . ".png') no-repeat;background:none,url('" . $localPath . "/images/"
                       . $value[0] . '-' . $iconShape . '-' . $iconColor . ".svg') no-repeat;}";

            // create the CSS for the icon hover background
            if ($iconHover == 'hoverOn') {
                $css .= '.' . $value[0] . $iconSize . '-' . $iconShape . '-' . $iconColor
                            . ":hover{background:url('" . $localPath . "/images/" . $value[0] . $iconSize . '-' . $iconShape
                            . "-hover.png') no-repeat;background:none,url('" . $localPath . "/images/"
                            . $value[0] . '-' . $iconShape . "-hover.svg') no-repeat;}";
            }

            echo "<style>$css</style>";

            // create the class for the link that has the icon backgrounds
            $class = $value[0] . $iconSize . '-' . $iconShape . '-' . $iconColor;

            // create the link and div
            $iconLink = "<a";
            $iconLink .= $openLinkBlank ? ' target="_blank" ' : ' ';
            $iconLink .= "style=\"margin-left: " . $iconMargin . "px; float: left;\" href=\"" . $value[1]
                      . "\"><div style=\"height: " . $iconSize . "px; width: " . $iconSize . "px\" class=\"" . $class . "\"></div></a>";

            echo $iconLink;
        }
    }

    // Example: CSS
    // <style>
    //     .flickr35-round-logo{
    //         background:url('/concrete5/packages/svg_social_media_icons/blocks/svg_social_media_icons/images/flickr35-round-logo.png') no-repeat;
    //         background:none,url('/concrete5/packages/svg_social_media_icons/blocks/svg_social_media_icons/images/dribbble-round-logo.svg') no-repeat;
    //     }
    //     .flickr35-round-logo:hover{
    //         background:url('/concrete5/packages/svg_social_media_icons/blocks/svg_social_media_icons/images/flickr35-round-hover.png') no-repeat;
    //         background:none,url('/concrete5/packages/svg_social_media_icons/blocks/svg_social_media_icons/images/dribbble-round-hover.svg') no-repeat;
    //     }
    // </style>

    // Example: link
    // <a style="margin-left: 0px; float: left;" href="https://www.flickr.com/photos/example/"><div style="height: 35px; width: 35px" class="flickr35-round-logo"></div></a>

    // Example: link open in new tab
    // <a target="_blank" style="margin-left: 0px; float: left;" href="https://www.flickr.com/photos/example/"><div style="height: 35px; width: 35px" class="flickr35-round-logo"></div></a>
    ?>

    </div>
</div>
