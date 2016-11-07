<?php
defined('C5_EXECUTE') or die("Access Denied.");

if (isset($displayBlockContainerSettings)) {
    $displayBlockContainerSettings = (bool) $displayBlockContainerSettings;
}

$backgroundColor = '';
$image = false;
$baseFontSize = '';
$backgroundRepeat = 'no-repeat';
$textColor = '';
$linkColor = '';
$marginTop = '';
$marginLeft = '';
$marginRight = '';
$marginBottom = '';
$paddingTop = '';
$paddingLeft = '';
$paddingRight = '';
$paddingBottom = '';
$borderStyle = '';
$borderWidth = '';
$borderColor = '';
$borderRadius = '';
$alignment = '';
$rotate = '';
$boxShadowHorizontal = '';
$boxShadowVertical = '';
$boxShadowBlur = '';
$boxShadowSpread = '';
$boxShadowColor = '';
$customClass = '';
$sliderMin = \Config::get('concrete.limits.style_customizer.size_min', -50);
$sliderMax = \Config::get('concrete.limits.style_customizer.size_max', 200);
$set = $style->getStyleSet();
if (is_object($set)) {
    $backgroundColor = $set->getBackgroundColor();
    $textColor = $set->getTextColor();
    $linkColor = $set->getLinkColor();
    $image = $set->getBackgroundImageFileObject();
    $backgroundRepeat = $set->getBackgroundRepeat();
    $baseFontSize = $set->getBaseFontSize();
    $marginTop = $set->getMarginTop();
    $marginLeft = $set->getMarginLeft();
    $marginRight = $set->getMarginRight();
    $marginBottom = $set->getMarginBottom();
    $paddingTop = $set->getPaddingTop();
    $paddingLeft = $set->getPaddingLeft();
    $paddingRight = $set->getPaddingRight();
    $paddingBottom = $set->getPaddingBottom();
    $borderStyle = $set->getBorderStyle();
    $borderWidth = $set->getBorderWidth();
    $borderColor = $set->getBorderColor();
    $borderRadius = $set->getBorderRadius();
    $alignment = $set->getAlignment();
    $rotate = $set->getRotate();
    $boxShadowHorizontal = $set->getBoxShadowHorizontal();
    $boxShadowVertical = $set->getBoxShadowVertical();
    $boxShadowBlur = $set->getBoxShadowBlur();
    $boxShadowSpread = $set->getBoxShadowSpread();
    $boxShadowColor = $set->getBoxShadowColor();
    $customClass = $set->getCustomClass();
}

$repeatOptions = array(
    'no-repeat' => t('No Repeat'),
    'repeat-x' => t('Horizontally'),
    'repeat-y' => t('Vertically'),
    'repeat' => t('Horizontally & Vertically')
);
$borderOptions = array(
    '' => t('None'),
    'solid' => t('Solid'),
    'dotted' => t('Dotted'),
    'dashed' => t('Dashed'),
    'double' => t('Double'),
    'groove' => t('Groove'),
    'ridge' => t('Ridge'),
    'inset' => t('Inset'),
    'outset' => t('Outset')
);

$alignmentOptions = array(
    '' => t('None'),
    'left' => t('Left'),
    'center' => t('Center'),
    'right' => t('Right'),
);


$customClassesSelect = array();

if (is_array($customClasses)) {
    foreach($customClasses as $class) {
        $customClassesSelect[$class] = $class;
    }
}

if ($style instanceof \Concrete\Core\Block\CustomStyle) {
    $method = 'concreteBlockInlineStyleCustomizer';
} else {
    $method = 'concreteAreaInlineStyleCustomizer';
}

$deviceHideClasses = array();
/* @var $gf \Concrete\Core\Page\Theme\GridFramework\GridFramework */
if (is_object($gf)) {
    $deviceHideClasses = $gf->getPageThemeGridFrameworkDeviceHideClasses();
}
$al = new Concrete\Core\Application\Service\FileManager();
$form = Core::make('helper/form');
?>

<form method="post" action="<?php echo $saveAction?>" id="ccm-inline-design-form">
<ul class="ccm-inline-toolbar ccm-ui">
    <li class="ccm-inline-toolbar-icon-cell"><a href="#" data-toggle="dropdown" title="<?php echo t('Text Size and Color')?>"><i class="fa fa-font"></i></a>

        <div class="ccm-inline-design-dropdown-menu dropdown-menu">
            <div>
                <?php echo t('Text Color')?>
                <?php echo Loader::helper('form/color')->output('textColor', $textColor);?>
            </div>
            <hr />
            <div>
                <?php echo t('Link Color')?>
                <?php echo Loader::helper('form/color')->output('linkColor', $linkColor);?>
            </div>
            <hr />
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Base Font Size')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                <span class="ccm-inline-style-slider-display-value">
                    <input type="text" name="baseFontSize" id="baseFontSize" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $baseFontSize ? $baseFontSize : '0px' ?>" <?php echo $baseFontSize ? '' : 'disabled' ?> autocomplete="off" />
                </span>
            </div>
            <div class="ccm-inline-select-container">
                <?php echo t('Alignment')?>
                <?php echo $form->select('alignment', $alignmentOptions, $alignment);?>
            </div>

        </div>

    </li>
    <li class="ccm-inline-toolbar-icon-cell"><a href="#" data-toggle="dropdown" title="<?php echo t('Background Color and Image')?>"><i class="fa fa-image"></i></a>

        <div class="ccm-inline-design-dropdown-menu dropdown-menu">
            <h3><?php echo t('Background')?></h3>
            <div>
                <?php echo t('Color')?>
                <?php echo Loader::helper('form/color')->output('backgroundColor', $backgroundColor);?>
            </div>
            <hr />
            <div>
                <?php echo t('Image')?>
                <?php echo $al->image('backgroundImageFileID', 'backgroundImageFileID', t('Choose Image'), $image);?>
            </div>
            <div class="ccm-inline-select-container">
                <?php echo t('Repeats')?>
                <?php echo $form->select('backgroundRepeat', $repeatOptions, $backgroundRepeat);?>
            </div>
        </div>

    </li>
    <li class="ccm-inline-toolbar-icon-cell"><a href="#" data-toggle="dropdown" title="<?php echo t('Borders')?>"><i class="fa fa-square-o"></i></a>
        <div class="ccm-inline-design-dropdown-menu dropdown-menu">
            <h3><?php echo t('Border')?></h3>
            <div>
                <?php echo t('Color')?>
                <?php echo Loader::helper('form/color')->output('borderColor', $borderColor);?>
            </div>
            <hr />
            <div class="ccm-inline-select-container">
                <?php echo t('Style')?>
                <?php echo $form->select('borderStyle', $borderOptions, $borderStyle);?>
            </div>
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Width')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
               <span class="ccm-inline-style-slider-display-value">
                <input type="text" name="borderWidth" id="borderWidth" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $borderWidth ? $borderWidth : '0px' ?>" <?php echo $borderWidth ? '' : 'disabled' ?> autocomplete="off" />
            </span>
            </div>
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Radius')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                <span class="ccm-inline-style-slider-display-value">
                    <input type="text" name="borderRadius" id="borderRadius" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $borderRadius ? $borderRadius : '0px' ?>" <?php echo $borderRadius ? '' : 'disabled' ?> autocomplete="off" />
                </span>
            </div>
        </div>
    </li>
    <li class="ccm-inline-toolbar-icon-cell"><a href="#" data-toggle="dropdown" title="<?php echo t('Margin and Padding')?>"><i class="fa fa-arrows-h"></i></a>
        <div class="ccm-inline-design-dropdown-menu <?php if ($style instanceof \Concrete\Core\Block\CustomStyle) { ?>ccm-inline-design-dropdown-menu-doubled<?php } ?> dropdown-menu">

        <div class="row">
            <div class="<?php if ($style instanceof \Concrete\Core\Block\CustomStyle) { ?>col-sm-6<?php } else { ?>col-sm-12<?php } ?>">
            <h3><?php echo t('Padding')?></h3>
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Top')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                <span class="ccm-inline-style-slider-display-value">
                    <input type="text" name="paddingTop" id="paddingTop" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $paddingTop ? $paddingTop : '0px' ?>" <?php echo $paddingTop ? '' : 'disabled' ?> autocomplete="off" />
                </span>
            </div>
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Right')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                <span class="ccm-inline-style-slider-display-value">
                    <input type="text" name="paddingRight" id="paddingRight" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $paddingRight ? $paddingRight : '0px' ?>" <?php echo $paddingRight ? '' : 'disabled' ?> autocomplete="off" />
                </span>
            </div>
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Bottom')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                <span class="ccm-inline-style-slider-display-value">
                    <input type="text" name="paddingBottom" id="paddingBottom" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $paddingBottom ? $paddingBottom : '0px' ?>" <?php echo $paddingBottom ? '' : 'disabled' ?> autocomplete="off" />
                </span>
            </div>
            <div>
                <span class="ccm-inline-style-slider-heading"><?php echo t('Left')?></span>
                <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
               <span class="ccm-inline-style-slider-display-value">
                <input type="text" name="paddingLeft" id="paddingLeft" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $paddingLeft ? $paddingLeft : '0px' ?>" <?php echo $paddingLeft ? '' : 'disabled' ?> autocomplete="off" />
            </span>
            </div>
            </div>

            <?php if ($style instanceof \Concrete\Core\Block\CustomStyle) { ?>
            <div class="col-sm-6">
                <h3><?php echo t('Margin')?></h3>
                <div>
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Top')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="marginTop" id="marginTop" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $marginTop ? $marginTop : '0px' ?>" <?php echo $marginTop ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
                <div>
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Right')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="marginRight" id="marginRight" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $marginRight ? $marginRight : '0px' ?>" <?php echo $marginRight ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
                <div>
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Bottom')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="marginBottom" id="marginBottom" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $marginBottom ? $marginBottom : '0px' ?>" <?php echo $marginBottom ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
                <div>
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Left')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="marginLeft" id="marginLeft" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $marginLeft ? $marginLeft : '0px' ?>" <?php echo $marginLeft ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
            </div>
            <?php } ?>
            </div>
            </div>

    </li>
    <li class="ccm-inline-toolbar-icon-cell"><a href="#" data-toggle="dropdown" title="<?php echo t('Shadow and Rotation (CSS3)')?>"><i class="fa fa-magic"></i></a>
        <div class="ccm-inline-design-dropdown-menu  ccm-inline-design-dropdown-menu-doubled dropdown-menu">

            <h3><?php echo t('Shadow')?></h3>

            <div class="row">
                <div class="col-sm-6">
                        <span class="ccm-inline-style-slider-heading"><?php echo t('Horizontal Position')?></span>
                        <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                        <span class="ccm-inline-style-slider-display-value">
                            <input type="text" name="boxShadowHorizontal" id="boxShadowHorizontal" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $boxShadowHorizontal ? $boxShadowHorizontal : '0px' ?>" <?php echo $boxShadowHorizontal ? '' : 'disabled' ?> autocomplete="off" />
                        </span>
                    </div>

                <div class="col-sm-6">
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Vertical Position')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="boxShadowVertical" id="boxShadowVertical" data-value-format="px" class="ccm-inline-style-slider-value" value="<?php echo $boxShadowVertical ? $boxShadowVertical : '0px' ?>" <?php echo $boxShadowVertical ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
            </div>
             <div class="row">
                 <div class="col-sm-6">
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Blur')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="boxShadowBlur" id="boxShadowBlur" class="ccm-inline-style-slider-value" data-value-format="px" value="<?php echo $boxShadowBlur ? $boxShadowBlur : '0px' ?>" <?php echo $boxShadowBlur ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
                 <div class="col-sm-6">
                    <span class="ccm-inline-style-slider-heading"><?php echo t('Spread')?></span>
                    <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                    <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="boxShadowSpread" id="boxShadowSpread" class="ccm-inline-style-slider-value" data-value-format="px" value="<?php echo $boxShadowSpread ? $boxShadowSpread : '0px' ?>" <?php echo $boxShadowSpread ? '' : 'disabled' ?> autocomplete="off" />
                    </span>
                </div>
             </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo t('Color')?>
                    <?php echo Loader::helper('form/color')->output('boxShadowColor', $boxShadowColor);?>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-6">
                    <h3><?php echo t('Rotate')?></h3>
                    <div>
                        <span class="ccm-inline-style-slider-heading"><?php echo t('Rotation (in degrees)')?></span>
                        <div class="ccm-inline-style-sliders" data-style-slider-min="<?php echo $sliderMin ?>" data-style-slider-max="<?php echo $sliderMax ?>" data-style-slider-default-setting="0"></div>
                       <span class="ccm-inline-style-slider-display-value">
                        <input type="text" name="rotate" id="rotate" class="ccm-inline-style-slider-value ccm-slider-value-unit-appended" data-value-format="" value="<?php echo $rotate ? $rotate : '0' ?>" autocomplete="off" /> &deg;
                    </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php if (count($deviceHideClasses)) { ?>
                    <h3><?php echo t('Device Visibility')?> <i class="fa fa-question-circle launch-tooltip" title="<?php echo t('Hide the current content on a particular type of device. Un-check a device below to hide the content.')?>"></i></h3>
                    <div class="btn-group">
                        <?php foreach($deviceHideClasses as $class) {
                            $hidden = false;
                            if (is_object($set)) {
                                $hidden = $set->isHiddenOnDevice($class);
                            }
                            ?>
                        <button type="button" data-hide-on-device="<?php echo $class?>" class="btn btn-default <?php if (!$hidden) { ?>active<?php } ?>"><i class="<?php echo $gf->getDeviceHideClassIconClass($class)?>"></i></button>
                        <?php } ?>
                    </div>
                        <?php foreach($deviceHideClasses as $class) {

                            $hidden = false;
                            if (is_object($set)) {
                                $hidden = $set->isHiddenOnDevice($class);
                            }

                            ?>
                            <input data-hide-on-device-input="<?php echo $class?>" type="hidden" name="hideOnDevice[<?php echo $class?>]" value="<?php if ($hidden) { ?>1<?php } else { ?>0<?php } ?>" />
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

    </li>
    <li class="ccm-inline-toolbar-icon-cell"><a href="#" data-toggle="dropdown" title="<?php echo t('Custom CSS Classes, Block Name, Custom Templates and Reset Styles')?>"><i class="fa fa-cog"></i></a>
        <div class="ccm-inline-design-dropdown-menu dropdown-menu">
            <h3><?php echo t('Advanced')?></h3>

            <div>
                <?php echo t('Custom Class')?>
                <?php echo $form->text('customClass', $customClass);?>
            </div>
            <hr/>

            <?php if ($style instanceof \Concrete\Core\Block\CustomStyle && $canEditCustomTemplate) { ?>
                <div class="ccm-inline-select-container">
                    <?php echo t('Custom Template')?>
                    <select id="bFilename" name="bFilename" class="form-control">
                        <option value="">(<?php echo t('None selected')?>)</option>
                        <?php
                        foreach($templates as $tpl) {
                            ?><option value="<?php echo $tpl->getTemplateFileFilename()?>" <?php if ($bFilename == $tpl->getTemplateFileFilename()) { ?> selected <?php } ?>><?php echo $tpl->getTemplateFileDisplayName()?></option><?php
                        }
                        ?>
                    </select>
                 </div>
                <hr/>

            <?php } ?>


            <?php if ($displayBlockContainerSettings) { ?>
                <div class="ccm-inline-select-container">
                    <?php echo t('Block Container Class')?>
                    <select id="enableBlockContainer" name="enableBlockContainer" class="form-control">
                        <option value="-1" <?php if ($enableBlockContainer == -1) { ?>selected<?php } ?>><?php echo t('Default Setting')?></option>
                        <option value="0"<?php if ($enableBlockContainer == 0) { ?>selected<?php } ?>><?php echo t('Disable Grid Container')?></option>
                        <option value="1" <?php if ($enableBlockContainer == 1) { ?>selected<?php } ?>><?php echo t('Enable Grid Container')?></option>
                    </select>
                </div>
                <hr/>

            <?php } ?>

            <div>
                <button data-reset-action="<?php echo $resetAction?>" data-action="reset-design" type="button" class="btn-block btn btn-danger"><?php echo t("Clear Styles")?></button>
            </div>
        </div>
    </li>
    <li class="ccm-inline-toolbar-button ccm-inline-toolbar-button-cancel">
        <button data-action="cancel-design" type="button" class="btn btn-mini"><?php echo t("Cancel")?></button>
    </li>
    <li class="ccm-inline-toolbar-button ccm-inline-toolbar-button-save">
        <button data-action="save-design" class="btn btn-primary" type="button"><?php echo t('Save')?></button>
    </li>
</ul>
</form>

<script type="text/javascript">
    $('#ccm-inline-design-form').<?php echo $method?>();
    $("#customClass").select2({tags:<?php echo json_encode(array_values($customClassesSelect)); ?>, separator: " "});

    $('button[data-hide-on-device]').on('click', function(e) {
        e.stopPropagation();
        var input = $(this).attr('data-hide-on-device');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $($('input[data-hide-on-device-input=' + input + ']').val(1));
        } else {
            $(this).addClass('active');
            $($('input[data-hide-on-device-input=' + input + ']').val(0));
        }
    });
</script>