<?php defined('C5_EXECUTE') or die("Access Denied.");

$btl = new BlockTypeList();
$blockTypes = $btl->get();
$handles = '';
$ap = new Permissions($a);
$class = 'ccm-area';
if ($a->isGlobalArea()) {
    $class .= ' ccm-global-area';
}

$c = Page::getCurrentPage();
$css = $c->getAreaCustomStyle($a);
if (is_object($css)) {
    $class .= ' ' . $css->getContainerClass();
}

$canAddGathering = false;

foreach ($blockTypes as $bt) {
    if ($ap->canAddBlockToArea($bt)) {
        $handles .= $bt->getBlockTypeHandle() . ' ';
        if ($bt->getBlockTypeHandle() == BLOCK_HANDLE_GATHERING) {
            $canAddGathering = true;
        }
    }
}

if ($ap->canAddLayout()) {
    $handles .= BLOCK_HANDLE_LAYOUT_PROXY . ' ';
}

if ($ap->canAddStack()) {
    $handles .= 'stack ';
}

if ($canAddGathering) {
    $handles .= BLOCK_HANDLE_GATHERING_ITEM_PROXY . ' ';
}

$c = Page::getCurrentPage();
if ($c->isMasterCollection()) {
    $handles .= BLOCK_HANDLE_PAGE_TYPE_OUTPUT_PROXY . ' ';
}

/** @var Page $c */
$pt = $c->getCollectionThemeObject();
$gf = $pt->getThemeGridFrameworkObject();
?>
<div id="a<?php echo $a->getAreaID() ?>" data-maximum-blocks="<?php echo $a->getMaximumBlocks() ?>"
     data-accepts-block-types="<?php echo trim($handles) ?>"
     data-area-id="<?php echo $a->getAreaID() ?>"
     data-cID="<?php echo $a->getCollectionID() ?>"
     data-area-handle="<?php echo h($a->getAreaHandle()) ?>"
     data-area-display-name="<?php echo h($a->getAreaDisplayName()) ?>"
     data-area-menu-handle="<?php echo $a->getAreaID() ?>"
     data-area-enable-grid-container="<?php echo $a->isGridContainerEnabled() ?>"
     data-launch-area-menu="area-menu-a<?php echo $a->getAreaID() ?>"
     data-area-custom-templates='<?php echo json_encode($a->getAreaCustomTemplates(), ENT_QUOTES)?>'
     class="<?php echo $class ?>">

    <?php unset($class); ?>
    <script type="text/template" role="area-block-wrapper">
        <?php
        if ($pt->supportsGridFramework() && $a->isGridContainerEnabled()) {
            echo $gf->getPageThemeGridFrameworkContainerStartHTML();
            echo $gf->getPageThemeGridFrameworkRowStartHTML();
            printf('<div class="%s">', $gf->getPageThemeGridFrameworkColumnClassesForSpan(
                                          $gf->getPageThemeGridFrameworkNumColumns()
            ));
            ?>
            <div class='block'></div>
            </div>
            <?php
            echo $gf->getPageThemeGridFrameworkRowEndHTML();
            echo $gf->getPageThemeGridFrameworkContainerEndHTML();
        } else {
            ?>
            <div class='block'></div>
            <?php
        }
        ?>
    </script>
    <div class="ccm-area-block-list">
