<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="ccm-ui">

    <?php if (count($frequentPageTypes) || count($otherPageTypes)) { ?>

    <?php if (count($frequentPageTypes) && count($otherPageTypes)) { ?>
        <h5><?php echo t('Commonly Used')?></h5>
    <?php } ?>

    <ul class="item-select-list">

        <?php foreach($frequentPageTypes as $pt) { ?>
            <li><a dialog-width="640" dialog-title="<?php echo t('Add %s', $pt->getPageTypeDisplayName())?>" dialog-height="550" class="dialog-launch" href="<?php echo URL::to('/ccm/system/dialogs/page/add/compose', $pt->getPageTypeID(), $c->getCollectionID())?>"><i class="fa fa-file-o"></i> <?php echo $pt->getPageTypeDisplayName()?></a></li>
        <?php } ?>

        <?php if (count($frequentPageTypes) && count($otherPageTypes)) { ?>
            </ul>
            <h5><?php echo t('Other')?></h5>
            <ul class="item-select-list">
        <?php } ?>

        <?php foreach($otherPageTypes as $pt) { ?>
            <li><a dialog-width="640" dialog-title="<?php echo t('Add %s', $pt->getPageTypeDisplayName())?>" dialog-height="550" class="dialog-launch" href="<?php echo URL::to('/ccm/system/dialogs/page/add/compose', $pt->getPageTypeID(), $c->getCollectionID())?>"><i class="fa fa-file-o"></i> <?php echo $pt->getPageTypeDisplayName()?></a></li>
        <?php } ?>
    </ul>

    <?php } else { ?>
        <p><?php echo t('You do not have access to add any page types beneath the selected page.')?></p>

    <?php } ?>
</div>