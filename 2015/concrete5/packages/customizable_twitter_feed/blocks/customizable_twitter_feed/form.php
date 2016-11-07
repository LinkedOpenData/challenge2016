<?php  defined('C5_EXECUTE') or die("Access Denied.");

print Core::make('helper/concrete/ui')->tabs(array(
    array('feed-details', t('Feed Details'), true),
    array('feed-settings', t('Feed Settings')),
    array('text-colors', t('Text and Colors'))
));

?>

<style>
    .two-columns {
        width: 50%;
        float: left;
    }
    .four-columns {
        width: 24%;
        display: inline-block;
    }
    .pixel-input-width {
        width: 100px;
    }
    .clear-both {
        clear: both;
    }
    .no-float {
        float: none;
    }
    .form-group input.validation-error {
        border: 1px solid red;
    }
    .validation-message {
        margin-top: 30px;
        color: red;
    }
</style>

<div id="validate"></div>

<div id="ccm-tab-content-feed-details" class="ccm-tab-content">

    <!-- Twitter Widget ID -->
    <div class="form-group">
        <?php  echo $form->label('widgetID', t('Twitter Widget ID'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Your widget ID is the data-widget-id=XXXXX found in the embed code.'); ?>"></i>
        <?php  print $form->text('widgetID', $widgetID)?>
    </div>

    <!-- Twitter Feed Title -->
    <div class="form-group">
        <?php  echo $form->label('feedTitle', t('Twitter Feed Title'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('The Twitter Feed Title is optional.'); ?>"></i>
        <?php  print $form->text('feedTitle', $feedTitle)?>
    </div>
    <div class="text-muted"><?php  echo t('For information on getting your widget ID:'); ?><br><a href="<?php  echo t('https://twittercommunity.com/t/how-do-you-get-twitter-widget-id'); ?>" target="_blank"><?php  echo t('https://twittercommunity.com/t/how-do-you-get-twitter-widget-id'); ?></a></div>
    <br>
    <div class="text-muted"><?php  echo t('Embedded timeline options:'); ?><br><a href="<?php  echo t('https://dev.twitter.com/web/embedded-timelines'); ?>" target="_blank"><?php  echo t('https://dev.twitter.com/web/embedded-timelines'); ?></a></div>
</div>

<div id="ccm-tab-content-feed-settings" class="ccm-tab-content">

    <!-- Tweets to Display -->
    <div class="form-group two-columns">
        <?php  echo $form->label('maxTweets', t('Tweets to Display'));?>
        <?php  echo $form->select('maxTweets', array('1' => '1', '2' => '2', '3' => '3',
        '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11',
        '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18',
        '19' => '19', '20' => '20'), $maxTweets, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Show User -->
    <div class="form-group two-columns">
        <?php  echo $form->label('showUser', t('Show User'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Show the user name, Twitter name, and user thumbnail image.'); ?>"></i>
        <?php  echo $form->select('showUser', array('true' => t('on'), 'false' => t('off')), $showUser, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Show Posted Time -->
    <div class="form-group two-columns">
        <?php  echo $form->label('showTime', t('Show Posted Time'));?>
        <?php  echo $form->select('showTime', array('true' => t('on'), 'false' => t('off')), $showTime, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Show User Interaction -->
    <div class="form-group two-columns">
        <?php  echo $form->label('showInteraction', t('Show User Interaction'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Show the Reply, Retweet, and Favorite links.'); ?>"></i>
        <?php  echo $form->select('showInteraction', array('true' => t('on'), 'false' => t('off')), $showInteraction, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Show Retweet -->
    <div class="form-group two-columns">
        <?php  echo $form->label('showRetweet', t('Show Retweets'));?>
        <?php  echo $form->select('showRetweet', array('true' => t('on'), 'false' => t('off')), $showRetweet, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Show Feed Images -->
    <div class="form-group two-columns">
        <?php  echo $form->label('showImages', t('Show Tweet Images'));?>
        <?php  echo $form->select('showImages', array('true' => t('on'), 'false' => t('off')), $showImages, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Enable Links -->
    <div class="form-group two-columns">
        <?php  echo $form->label('enableLinks', t('Enable Links'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Control whether feed text links are plain text or anchor tags. Enable Links set to \'on\' will also abbreviate the time posted and disable the user thumbnail image.'); ?>"></i>
        <?php  echo $form->select('enableLinks', array('true' => t('on'), 'false' => t('off')), $enableLinks, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Open Links in New Window -->
    <div class="form-group two-columns">
        <?php  echo $form->label('linksInNewWindow', t('Open Links in New Window'));?>
        <?php  echo $form->select('linksInNewWindow', array('true' => t('on'), 'false' => t('off')), $linksInNewWindow, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Tweet Divider -->
    <div class="form-group two-columns">
        <?php  echo $form->label('tweetDivider', t('Tweet Divider'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Add a horizontal divider between tweets.'); ?>"></i>
        <?php  echo $form->select('tweetDivider', array('on' => t('on'), 'off' => t('off')), $tweetDivider, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Max Width -->
    <div class="form-group two-columns clear-both">
        <?php  echo $form->label('maxWidth', t('Max Width'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('When a width is not set, or set to 0, the default max-width will be 520px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('maxWidth', $maxWidth ? $maxWidth : '0', array('style' => 'text-align: center;', 'maxlength' => '4', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

    <!-- Feed Padding -->
    <div class="form-group two-columns">
        <?php  echo $form->label('feedPadding', t('Feed Padding'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Add padding to the feed container.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('feedPadding', $feedPadding ? $feedPadding : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

</div>

<div id="ccm-tab-content-text-colors" class="ccm-tab-content">

    <!-- Feed Theme -->
    <div class="form-group two-columns no-float">
        <?php  echo $form->label('feedTheme', t('Feed Theme'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Setting a feed theme will override font and divider colors.'); ?>"></i>
        <?php  echo $form->select('feedTheme', array('no theme' => t('no theme'), 'light' => t('light'), 'dark' => t('dark')), $feedTheme, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Feed Background Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Background Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('feedBackgroundColor', $feedBackgroundColor, array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Feed Title Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Feed Title Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('feedTitleColor', $feedTitleColor ? $feedTitleColor : "#000000", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Name Text Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Name Text Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('nameTextColor', $nameTextColor ? $nameTextColor : "#000000", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Feed Text Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Feed Text Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('feedTextColor', $feedTextColor ? $feedTextColor : "#000000", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Feed Link Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Feed Link Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('feedLinkColor', $feedLinkColor ? $feedLinkColor : "#868686", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Feed Link Hover Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Feed Link Hover Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('feedLinkHoverColor', $feedLinkHoverColor ? $feedLinkHoverColor : "#46a3d9", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Posted Time Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Posted Time Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('timePostedColor', $timePostedColor ? $timePostedColor : "#46a3d9", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Tweet Divider Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">' . t('Tweet Divider Color') . '</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('tweetDividerColor', $tweetDividerColor ? $tweetDividerColor : "#000000", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Feed Title Font Size -->
    <div class="form-group two-columns">
        <?php  echo $form->label('feedTitleTextSize', t('Feed Title Font Size'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('When a font size is not set, or set to 0, the default font size will be 18px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('feedTitleTextSize', $feedTitleTextSize ? $feedTitleTextSize : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

    <!-- Name Font Size -->
    <div class="form-group two-columns">
        <?php  echo $form->label('nameTextSize', t('Name Font Size'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('When a font size is not set, or set to 0, the default font size will be 16px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('nameTextSize', $nameTextSize ? $nameTextSize : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

    <!-- @Name Font Size -->
    <div class="form-group two-columns">
        <?php  echo $form->label('atNameTextSize', t('@Name Font Size'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('When a font size is not set, or set to 0, the default font size will be 14px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('atNameTextSize', $atNameTextSize ? $atNameTextSize : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

    <!-- Feed Text Font Size -->
    <div class="form-group two-columns">
        <?php  echo $form->label('feedTextSize', t('Feed Text Font Size'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('When a font size is not set, or set to 0, the default font size will be 14px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('feedTextSize', $feedTextSize ? $feedTextSize : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

    <!-- Posted Time Text Size -->
    <div class="form-group two-columns">
        <?php  echo $form->label('timePostedTextSize', t('Posted Time Text Size'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('When a font size is not set, or set to 0, the default font size will be 12px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('timePostedTextSize', $timePostedTextSize ? $timePostedTextSize : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

    <!-- Interact Links Text Size -->
    <div class="form-group two-columns">
        <?php  echo $form->label('interactTextSize', t('Interact Links Text Size'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('The Reply Retweet Favorite links. When a font size is not set, or set to 0, the default font size will be 12px.'); ?>"></i>
        <div class="input-group pixel-input-width">
        <?php  print $form->text('interactTextSize', $interactTextSize ? $interactTextSize : '0', array('style' => 'text-align: center;', 'maxlength' => '3', 'class' => 'validation'))?><span class="input-group-addon">px</span>
        </div>
    </div>

</div>
<script>
$("#ccm-form-submit-button").click(function(event){
    $('.validation').each (function() {
        if (isNaN($(this).val()) || $(this).val() < '0') {
            $(this).addClass('validation-error');
            $('#validate').text('<?php  echo t("Valid input values for Max Width, Feed Padding, and Font Sizes are 0 or positive numbers."); ?>')
                          .addClass('well validation-message');
            event.preventDefault();
        } else {
            $(this).removeClass('validation-error');
        }
    });
});
</script>