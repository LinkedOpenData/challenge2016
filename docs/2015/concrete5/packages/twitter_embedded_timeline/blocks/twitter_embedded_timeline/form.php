<?php  defined('C5_EXECUTE') or die("Access Denied.");

print Core::make('helper/concrete/ui')->tabs(array(
    array('profile-details', t('Profile Details'), true),
    array('widget-settings', t('Widget Settings'))
));

?>

<style>
    .two-columns {
        width: 50%;
        float: left;
    }
    .four-columns {
        width: 25%;
        float: left;
    }
    .clear-both {
        clear: both;
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

<div id="ccm-tab-content-profile-details" class="ccm-tab-content">

    <!-- Twitter Profile Name -->
    <div class="form-group">
        <?php  echo $form->label('profileName', t('Twitter Profile Name'));?>
        <div class="input-group">
            <span class="input-group-addon">@</span>
            <?php  print $form->text('profileName', $profileName, array('placeholder' => t('your_name')))?>
        </div>
    </div>

    <!-- Twitter Profile Address -->
    <div class="form-group">
        <?php  echo $form->label('profileAddress', t('Twitter Profile Address'));?>
        <?php  print $form->text('profileAddress', $profileAddress, array('placeholder' => t('https://twitter.com/your_name')))?>
    </div>

    <!-- Widget ID -->
    <div class="form-group">
        <?php  echo $form->label('widgetID', t('Widget ID'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Your widget ID is the data-widget-id=XXXXXXXX found in the embed code.'); ?>"></i>
        <?php  print $form->text('widgetID', $widgetID)?>
    </div>
    <div class="text-muted"><?php  echo t('For information on getting your widget ID:'); ?><br><a href="<?php  echo t('https://twittercommunity.com/t/how-do-you-get-twitter-widget-id'); ?>" target="_blank"><?php  echo t('https://twittercommunity.com/t/how-do-you-get-twitter-widget-id'); ?></a></div>
    <br>
    <div class="text-muted"><?php  echo t('Embedded timeline options:'); ?><br><a href="<?php  echo t('https://dev.twitter.com/web/embedded-timelines'); ?>" target="_blank"><?php  echo t('https://dev.twitter.com/web/embedded-timelines'); ?></a></div>

</div>

<div id="ccm-tab-content-widget-settings" class="ccm-tab-content">

    <!-- Tweets Displayed -->
    <div class="form-group two-columns">
        <?php  echo $form->label('tweetsDisplayed', t('Tweets Displayed'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Tweets Displayed set to default will show a scrollable list of all tweets. When Tweets Displayed is limited to a certain number, the list of tweets is not scrollable.'); ?>"></i>
        <?php  echo $form->select('tweetsDisplayed', array('0' => 'default', '1' => '1', '2' => '2', '3' => '3',
        '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11',
        '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18',
        '19' => '19', '20' => '20'), $tweetsDisplayed, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Widget Theme -->
    <div class="form-group two-columns">
        <?php  echo $form->label('widgetTheme', t('Widget Theme'));?>
        <?php  echo $form->select('widgetTheme', array('light' => t('light'), 'dark' => t('dark')), $widgetTheme, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Transparent Background -->
    <div class="form-group two-columns">
        <?php  echo $form->label('transparentBackground', t('Transparent Background'));?>
        <?php  echo $form->select('transparentBackground', array('transparent' => t('on'), 'off' => t('off')), $transparentBackground, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Widget Header -->
    <div class="form-group two-columns">
        <?php  echo $form->label('widgetHeader', t('Widget Header'));?>
        <?php  echo $form->select('widgetHeader', array('on' => t('on'), 'noheader' => t('off')), $widgetHeader, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Widget Border -->
    <div class="form-group two-columns">
        <?php  echo $form->label('widgetBorder', t('Widget Border'));?>
        <?php  echo $form->select('widgetBorder', array('on' => t('on'), 'noborders' => t('off')), $widgetBorder, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Widget Footer -->
    <div class="form-group two-columns">
        <?php  echo $form->label('widgetFooter', t('Widget Footer'));?>
        <?php  echo $form->select('widgetFooter', array('on' => t('on'), 'nofooter' => t('off')), $widgetFooter, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Widget Scrollbar -->
    <div class="form-group two-columns">
        <?php  echo $form->label('widgetScrollbar', t('Widget Scrollbar'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('The scrollbar can only be enabled or disabled when Tweets Displayed is set to default. The widget is still scrollable even without the scrollbar, if Tweets Displayed is set to default.'); ?>"></i>
        <?php  echo $form->select('widgetScrollbar', array('on' => t('on'), 'noscrollbar' => t('off')), $widgetScrollbar, array('style' => 'width: 125px;')); ?>
    </div>

    <!-- Link Color -->
    <div class="form-group four-columns clear-both">
        <?php   echo '<label class="control-label">Link Color</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('linkColor', $linkColor ? $linkColor : "#000000", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Border Color -->
    <div class="form-group four-columns">
        <?php   echo '<label class="control-label">Border Color</label>'; ?>
        <br>
        <?php 
        $color = Core::make('helper/form/color');
        $color->output('borderColor', $borderColor ? $borderColor : "#000000", array('preferredFormat'=>'hex'));
        ?>
    </div>

    <!-- Height -->
    <div class="form-group four-columns clear-both">
        <?php  echo $form->label('height', t('Height'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('Height can only be set when Tweets Displayed is set to default.'); ?>"></i>
        <?php  print $form->text('height', $height ? $height : '0', array('style' => 'width: 60px; text-align: center;', 'maxlength' => '4', 'class' => 'validation'))?>
    </div>

    <!-- Width -->
    <div class="form-group four-columns">
        <?php  echo $form->label('width', t('Width'));?>
        <i class="fa fa-question-circle launch-tooltip" title="" data-original-title="<?php  echo t('The minimum width that can be set is 180px. When a width is not set, the width will be 100%, with a max-width of 520px.'); ?>"></i>
        <?php  print $form->text('width', $width ? $width : '0', array('style' => 'width: 60px; text-align: center;', 'maxlength' => '4', 'class' => 'validation'))?>
    </div>

</div>
<script>
$("#ccm-form-submit-button").click(function(event){
    $('.validation').each (function() {
        if (isNaN($(this).val()) || $(this).val() < '0') {
            $(this).addClass('validation-error');
            $('#validate').text('<?php  echo t("Valid input values for Height and Width are 0 or positive numbers."); ?>')
                          .addClass('well validation-message');
            event.preventDefault();
        } else {
            $(this).removeClass('validation-error');
        }
    });
});
</script>