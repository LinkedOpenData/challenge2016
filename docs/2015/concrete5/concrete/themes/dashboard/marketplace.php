<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<div id="ccm-marketplace-wrapper">

<header class="ccm-marketplace">

    <?php if ($controller->getTask() == 'view_detail') { ?>
        <div class="ccm-marketplace-nav">
            <nav>
            <li><a href="<?php echo $controller->action('view')?>"><i class="fa fa-chevron-left"></i> <?php echo t('Back')?></a></li>
            </nav>
        </div>
    <?php } else { ?>
        <form action="<?php echo $controller->action('view')?>" method="get">
            <input type="hidden" name="ccm_order_by" value="<?php echo $sort?>" />
        <div class="ccm-marketplace-nav">
            <nav>
            <li><a href="<?php echo URL::to('/dashboard/extend/themes')?>" <?php if ($type == 'themes') { ?>class="active"<?php } ?>><?php echo t('Themes')?></a></li>
            <li><a href="<?php echo URL::to('/dashboard/extend/addons')?>" <?php if ($type == 'addons') { ?>class="active"<?php } ?>><?php echo t('Add-Ons')?></a></li>
            </nav>
        </div>
        <div class="ccm-marketplace-search">
            <?php echo $form->select('marketplaceRemoteItemSetID', $sets, $selectedSet, array('style' => 'width: 150px'))?>
            <div class="ccm-marketplace-search-input">
                <i class="fa fa-search"></i>
                <input type="search" name="keywords" value="<?php echo $keywords?>" />
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><?php echo t('Search')?></button>
        </div>
        </form>
    <?php } ?>
</header>


<?php if ($controller->getTask() != 'view_detail') { ?>
<header class="ccm-marketplace-list">
    <h1><?php echo $heading?></h1>
    <div class="ccm-marketplace-sort">
        <nav>
        <li><a href="<?php echo $list->getSortByURL('popularity')?>" <?php if ($sort == 'popularity') { ?>class="active"<?php } ?>><?php echo t('Most Popular')?></a></li>
        <li><a href="<?php echo $list->getSortByURL('recent')?>" <?php if ($sort == 'recent') { ?>class="active"<?php } ?>><?php echo t('Recent')?></a></li>
        <li><a href="<?php echo $list->getSortByURL('price')?>" <?php if ($sort == 'price') { ?>class="active"<?php } ?>><?php echo t('Price')?></a></li>
        <li><a href="<?php echo $list->getSortByURL('rating')?>" <?php if ($sort == 'rating') { ?>class="active"<?php } ?>><?php echo t('Rating')?></a></li>
        <li><a href="<?php echo $list->getSortByURL('skill_level')?>" <?php if ($sort == 'skill_level') { ?>class="active"<?php } ?>><?php echo t('Skill Level')?></a></li>
        </nav>
    </div>
</header>

<?php } ?>


<?php print $innerContent; ?>

</div>


<?php $this->inc('elements/footer.php');
