<?php   defined('C5_EXECUTE') or die("Access Denied.");

$urlHelper = Core::make('helper/concrete/urls');
$blockType = BlockType::getByHandle('svg_social_media_icons');
$localPath = $urlHelper->getBlockTypeAssetsURL($blockType);
?>

<?php  $sortOrderArray = explode(',', $sortOrder); ?>

<?php 
$iconList[] = '';

foreach ($sortOrderArray as $iconOrder) {
    $lower_case_name = strtolower($iconOrder);

    if ($icon[$lower_case_name][checked]) {
        $iconList[] = array($lower_case_name, $icon[$lower_case_name][address]);
    }
}
?>

<div class="icon-container-wrapper icon-clearfix">
    <div class="icon-container icon-clearfix">

    <?php  $iconStyleTag = '<style>'; ?>

    <?php 
     foreach ($iconList as $value) {
         if ($value[0]) {
             $iconStyleTag .= $controller->buildStyleTag($value[0], $iconSize, $iconShape, $iconColor, $iconHover, $localPath);
             echo $controller->iconDisplay($value[0], $value[1], $iconMargin,$iconSize, $iconShape, $iconColor);
         }
     }
     ?>

    <?php  $iconStyleTag .= '</style>'; ?>

    <?php  $controller->setIconStyleTag($iconStyleTag); ?>

    </div>
</div>
