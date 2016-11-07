<?php  defined('C5_EXECUTE') or die("Access Denied.");

print Core::make('helper/concrete/ui')->tabs(array(
    array('accounts', t('Social Media Accounts'), true),
    array('colorstyle', t('Color and Style'))
));

$urlHelper = Core::make('helper/concrete/urls');
$blockType = BlockType::getByHandle('svg_social_media_icons');
$localPath = $urlHelper->getBlockTypeAssetsURL($blockType);
?>

<style>
.ccm-block-svg_social_media_icons .size25 {
    height: 25px;
    width: 25px;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.ccm-block-svg_social_media_icons .size30 {
    height: 30px;
    width: 30px;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.ccm-block-svg_social_media_icons .size35 {
    height: 35px;
    width: 35px;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.ccm-block-svg_social_media_icons .size40 {
    height: 40px;
    width: 40px;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.ccm-block-svg_social_media_icons .size45 {
    height: 45px;
    width: 45px;
    margin: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.ccm-block-svg_social_media_icons .grey {
    background: #BEBEBE;
}

.ccm-block-svg_social_media_icons .facebook-round-logo {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-logo.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-black {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-black.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-grey {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-grey.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-white {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-white.svg') no-repeat;
}

.ccm-block-svg_social_media_icons .facebook-round-logo:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-hover.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-black:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-hover.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-grey:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-hover.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-white:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-hover.svg') no-repeat;
}

.ccm-block-svg_social_media_icons .facebook-round-logo-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-logo.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-black-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-black.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-grey-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-grey.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-round-white-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-round-white.svg') no-repeat;
}

.ccm-block-svg_social_media_icons .facebook-square-logo {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-logo.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-black {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-black.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-grey {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-grey.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-white {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-white.svg') no-repeat;
}

.ccm-block-svg_social_media_icons .facebook-square-logo:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-hover.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-black:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-hover.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-grey:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-hover.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-white:hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-hover.svg') no-repeat;
}

.ccm-block-svg_social_media_icons .facebook-square-logo-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-logo.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-black-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-black.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-grey-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-grey.svg') no-repeat;
}
.ccm-block-svg_social_media_icons .facebook-square-white-no-hover {
    background: url('<?php  echo $localPath; ?>/images/facebook-square-white.svg') no-repeat;
}

.ccm-block-svg_social_media_icons ul#sortable {
    margin: 0;
    padding: 0;
    border: none;
}
.ccm-block-svg_social_media_icons #sortable li.ui-state-default {
    margin: 0 0 10px 0;
    padding: 0;
    list-style: none;
    border: none;
}
.ccm-block-svg_social_media_icons #sortable .ui-state-highlight {
    height: 55px;
    line-height: 1.2em;
    list-style: none;
}

.ccm-block-svg_social_media_icons .input-group-addon.move {
    cursor: move;
}
</style>

<div id="ccm-tab-content-accounts" class="ccm-tab-content ccm-block-svg_social_media_icons">

    <!-- Open Links in New Tab -->
    <div class="form-group">
        <?php  echo $form->label('openLinkBlank', t('Open Links in New Tab'));?>
        <?php  echo $form->select('openLinkBlank', array(1 => t('on'), 0 => t('off')), $openLinkBlank, array('style' => 'width: 95px;')); ?>
    </div>

    <!-- Accounts -->
    <div class="form-group">

<?php 
// when the block is first used, there is no $sortOrder string
// without the $sortOrder string, there are no names to use for id, label name, etc
// this creates an initial $sortOrder string to use
if (!$sortOrder) {
    $sortOrder = 'Behance,deviantART,Dribbble,Email,Facebook,Flickr,Github,GooglePlus,Instagram,iTunes,Linkedin,Pinterest,Skype,SoundCloud,Spotify,Tumblr,Twitter,Vimeo,Youtube';
}

// split the $sortOrder string using "," and return the substrings as an array
$sortOrderArray = explode(',', $sortOrder);
?>

        <ul id="sortable">

            <?php 
            // Placeholder Text
            foreach ($sortOrderArray as $name) {

                switch ($name) {
                    case 'Behance';
                        $placeholder = t("https://www.behance.net/your-account-name");
                        break;
                    case 'deviantART';
                        $placeholder = t("https://your-account-name.deviantart.com");
                        break;
                    case 'Dribbble';
                        $placeholder = t("https://dribbble.com/your-account-name");
                        break;
                    case 'Email';
                        $placeholder = t("mailto:your-email-address@example.com");
                        break;
                    case 'Facebook';
                        $placeholder = t("https://www.facebook.com/your-account-name");
                        break;
                    case 'Flickr';
                        $placeholder = t("https://www.flickr.com/photos/your-account-name");
                        break;
                    case 'Github';
                        $placeholder = t("https://github.com/your-account-name");
                        break;
                    case 'GooglePlus';
                        $placeholder = t("https://plus.google.com/+your-account-name");
                        break;
                    case 'Instagram';
                        $placeholder = t("http://instagram.com/your-account-name");
                        break;
                    case 'iTunes';
                        $placeholder = t("https://itunes.apple.com/...");
                        break;
                    case 'Linkedin';
                        $placeholder = t("https://www.linkedin.com/in/your-account-name");
                        break;
                    case 'Pinterest';
                        $placeholder = t("https://www.pinterest.com/your-account-name");
                        break;
                    case 'Skype';
                        $placeholder = t("skype:profile_name?your-account-name");
                        break;
                    case 'SoundCloud';
                        $placeholder = t("https://soundcloud.com/your-account-name");
                        break;
                    case 'Spotify';
                        $placeholder = t("https://play.spotify.com/artist/your-account-name");
                        break;
                    case 'Tumblr';
                        $placeholder = t("http://www.your-account-name.tumblr.com");
                        break;
                    case 'Twitter';
                        $placeholder = t("https://twitter.com/your-account-name");
                        break;
                    case 'Vimeo';
                        $placeholder = t("http://vimeo.com/your-account-name");
                        break;
                    case 'Youtube';
                        $placeholder = t("https://www.youtube.com/user/your-account-name");
                        break;
                    default;
                        $placeholder = '';
                        break;
                }

                $lower_case_name = strtolower($name);

                // Build Account List Items
                echo "<li id=\"{$name}\" class=\"ui-state-default\">";
                echo $form->label($lower_case_name, t($name));
                echo '<div class="input-group">';
                echo '<span class="input-group-addon">';
                $iconChecked = $icon[$lower_case_name]['checked'] ? true : false;
                echo $form->checkbox('icon[' . $lower_case_name . '][checked]', $lower_case_name , $iconChecked);
                echo '</span>';
                echo '<input id="' . $lower_case_name . '" type="text" name="icon[' . $lower_case_name  . '][address]" value="' . $icon[$lower_case_name]['address'] . '" placeholder="' . $placeholder . '" class="form-control ccm-input-text">';
                echo '<span class="input-group-addon move"><i class="fa fa-arrows-v"></i></span>';
                echo '</div>';
                echo '</li>';
            }

            // Example: list item
            // <li id="Facebook" class="ui-state-default ui-sortable-handle">
            //     <label for="facebook" class="control-label">Facebook</label>
            //     <div class="input-group">
            //         <span class="input-group-addon">
            //             <input type="checkbox" id="icon[facebook][checked]" name="icon[facebook][checked]" class="ccm-input-checkbox" value="facebook">
            //         </span>
            //         <input id="facebook" type="text" name="icon[facebook][address]" value="" placeholder="https://www.facebook.com/your-account-name" class="form-control ccm-input-text">
            //         <span class="input-group-addon move">
            //             <i class="fa fa-arrows-v"></i>
            //         </span>
            //     </div>
            // </li>
            ?>

        </ul>

        <div>
            <?php  echo $form->hidden('sortOrder', $sortOrder) ?>
        </div>

    </div>
</div>

<div class="ccm-tab-content ccm-block-svg_social_media_icons" id="ccm-tab-content-colorstyle" style="position: relative; height: 475px;">

    <!-- Icon Preview -->
    <div id="icon-preview-container" style="position: absolute; right: 85px; top: 20px;">
        <label><?php  echo t('Icon Preview'); ?></label>
        <div id="center-boundary" style="height: 60px; position: relative; outline: 1px solid black;">
            <div id="icon-preview" style="position: absolute;"></div>
        </div>
    </div>

    <div class="form-group">

        <!-- Icon Shape -->
        <?php  echo $form->label('iconShape', t('Icon Shape'));?>
        <?php  echo $form->select('iconShape', array('round' => t('round'), 'square' => t('square')), $iconShape, array('style' => 'width: 125px;')); ?>
        <br>

        <!-- Icon Color -->
        <?php  echo $form->label('iconColor', t('Icon Color'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('The logo icon color uses the original logo color - e.g. Facebook is blue.'); ?>"></i>
        <?php  echo $form->select('iconColor', array( 'logo' => t('logo'), 'black' => t('black'), 'grey' => t('grey'), 'white' => t('white')), $iconColor, array('style' => 'width: 125px;')); ?>
        <br>

        <!-- Icon Hover -->
        <?php  echo $form->label('iconHover', t('Icon Hover'));?>
        <?php  echo $form->select('iconHover', array('hoverOn' => t('on'), 'hoverOff' => t('off')), $iconHover, array('style' => 'width: 95px;')); ?>
        <br>

        <!-- Icon Size -->
        <?php  echo $form->label('iconSize', t('Icon Size'));?>
        <?php  echo $form->select('iconSize', array('25' => '25px', '30' => '30px', '35' => '35px', '40' => '40px', '45' => '45px'), $iconSize, array('style' => 'width: 95px;')); ?>
        <br>

        <!-- Icon Spacing -->
        <?php  echo $form->label('iconMargin', t('Icon Spacing'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Space icons apart by adding margin between them.'); ?>"></i>
        <div class="input-group" style="width: 95px">
            <?php  print $form->text('iconMargin', $iconMargin, array('style' => 'text-align: center;'))?>
            <span class="input-group-addon">px</span>
        </div>
        <br>

        <!-- Position -->
        <?php  echo $form->label('position', t('Position'));?>
        <?php  echo $form->select('position', array(0 => t('left'), 1 => t('right')), $position, array('style' => 'width: 95px;')); ?>

    </div>

</div>

<script>
$(function() {
    $('#sortable').sortable({
        // add a placeholder when items are moved
        // default styling set by concrete5's jQuery UI customized CSS
        placeholder: "ui-state-highlight",
        // limit the dragging to the y axis
        axis: "y",
        // when items are dragged, the move cursor is used
        cursor: "move",
        create: function(event, ui) {
            var iconOrder = $(this).sortable('toArray').toString();
            $('#sortOrder').val(iconOrder);
        },
        // this event is triggered when the user stops sorting and the DOM position has changed
        // saves the item position to an array using the id name
        update: function(event, ui) {
            var iconOrder = $(this).sortable('toArray').toString();
            $('#sortOrder').val(iconOrder);
        }
    });
});
</script>

<script>
var iconPreview = document.getElementById('icon-preview'),
    iconShape   = document.getElementById('iconShape'),
    iconColor   = document.getElementById('iconColor'),
    iconHover   = document.getElementById('iconHover'),
    iconSize    = document.getElementById('iconSize'),
    previewBackground    = document.getElementById('center-boundary');


iconShape.addEventListener('change', showPreview);
iconColor.addEventListener('change', showPreview);
iconHover.addEventListener('change', showPreview);
iconSize.addEventListener('change', showPreview);

function showPreview()
{

    var shape = iconShape.value,
        color = iconColor.value,
        hover = '',
        backgroundColor = '',
        size;

    if (iconSize.value === '25') {
        size = ' size25';
    } else if (iconSize.value === '30') {
        size = ' size30';
    } else if (iconSize.value === '35') {
        size = ' size35';
    } else if (iconSize.value === '40') {
        size = ' size40';
    } else if (iconSize.value === '45') {
        size = ' size45';
    }

    if (iconHover.value === 'hoverOff') {
        hover = '-no-hover';
    }

    if (iconColor.value === 'white') {
        backgroundColor = 'grey';
    }

    var finalClasses = 'facebook-' + shape + '-' + color + hover + size;

    iconPreview.className = finalClasses;

    previewBackground.className = backgroundColor;

}

document.addEventListener('DOMContentLoaded', showPreview());
</script>
