<?php

defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Attribute\Select\OptionList;

?>

<?php if ($options instanceof OptionList && $options->count() > 0): ?>

<div class="ccm-block-tags-wrapper">

    <?php if ($title): ?>
        <div class="ccm-block-tags-header">
            <h5><?php echo $title?></h5>
        </div>
    <?php endif; ?>

    <?php foreach($options as $option) { ?>

        <?php if ($target) { ?>
            <a href="<?php echo $controller->getTagLink($option) ?>">
                <span class="ccm-block-tags-tag label"><?php echo $option->getSelectAttributeOptionValue()?></span>
            </a>
        <?php } else { ?>
            <span class="ccm-block-tags-tag label"><?php echo $option->getSelectAttributeOptionValue()?></span>
        <?php } ?>
    <?php } ?>


</div>

<?php endif; ?>