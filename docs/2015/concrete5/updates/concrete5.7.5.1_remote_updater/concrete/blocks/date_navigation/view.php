<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-block-date-navigation-wrapper">

    <div class="ccm-block-date-navigation-header">
        <h5><?php echo h($title)?></h5>
    </div>

    <?php if (count($dates)) { ?>
        <ul class="ccm-block-date-navigation-dates">
            <li><a href="<?php echo $view->controller->getDateLink()?>"><?php echo t('All')?></a></li>

            <?php foreach($dates as $date) { ?>
                <li><a href="<?php echo $view->controller->getDateLink($date)?>"
                        <?php if ($view->controller->isSelectedDate($date)) { ?>
                            class="ccm-block-date-navigation-date-selected"
                        <?php } ?>><?php echo $view->controller->getDateLabel($date)?></a></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <?php echo t('None.')?>
    <?php } ?>


</div>
