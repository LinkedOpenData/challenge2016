<?php
defined('C5_EXECUTE') or die("Access Denied.");
$sets = BlockTypeSet::getList();
$types = array();
foreach ($blockTypes as $bt) {
    if (!$cp->canAddBlockType($bt)) {
        continue;
    }

    $btsets = $bt->getBlockTypeSets();
    foreach ($btsets as $set) {
        $types[$set->getBlockTypeSetName()][] = $bt;
    }
    if (count($btsets) == 0) {
        $types['Other'][] = $bt;
    }
}

for ($i = 0; $i < count($sets); $i++) {
    $set = $sets[$i];
?>

<div class="ccm-ui" id="ccm-add-block-list">

<section>
    <legend><?php echo $set->getBlockTypeSetDisplayName() ?></legend>
    <ul class="item-select-list">
        <?php $blockTypes = $types[$set->getBlockTypeSetName()];
        foreach ($blockTypes as $bt) {
            $btIcon = $ci->getBlockTypeIconURL($bt);
            ?>
            <li>
                <a
                    data-cID="<?php echo $c->getCollectionID() ?>"
                    data-block-type-handle="<?php echo $bt->getBlockTypeHandle() ?>"
                    data-dialog-title="<?php echo t('Add %s', t($bt->getBlockTypeName())) ?>"
                    data-dialog-width="<?php echo $bt->getBlockTypeInterfaceWidth() ?>"
                    data-dialog-height="<?php echo $bt->getBlockTypeInterfaceHeight() ?>"
                    data-has-add-template="<?php echo $bt->hasAddTemplate() ?>"
                    data-supports-inline-add="<?php echo $bt->supportsInlineAdd() ?>"
                    data-btID="<?php echo $bt->getBlockTypeID() ?>"
                    title="<?php echo t($bt->getBlockTypeName()) ?>"
                    href="javascript:void(0)"><img src="<?php echo $btIcon?>" /> <?php echo t($bt->getBlockTypeName())?></a>
            </li>
        <?php } ?>
    </ul>
</section>

<?php } ?>

<?php if (is_array($types['Other'])) { ?>

    <section>
        <legend><?php echo t('Other')?></legend>
        <ul class="item-select-list">
            <?php $blockTypes = $types['Other'];
            foreach ($blockTypes as $bt) {
                $btIcon = $ci->getBlockTypeIconURL($bt);
                ?>
                <li>
                    <a
                        data-cID="<?php echo $c->getCollectionID() ?>"
                        data-block-type-handle="<?php echo $bt->getBlockTypeHandle() ?>"
                        data-dialog-title="<?php echo t('Add %s', t($bt->getBlockTypeName())) ?>"
                        data-dialog-width="<?php echo $bt->getBlockTypeInterfaceWidth() ?>"
                        data-dialog-height="<?php echo $bt->getBlockTypeInterfaceHeight() ?>"
                        data-has-add-template="<?php echo $bt->hasAddTemplate() ?>"
                        data-supports-inline-add="<?php echo $bt->supportsInlineAdd() ?>"
                        data-btID="<?php echo $bt->getBlockTypeID() ?>"
                        title="<?php echo t($bt->getBlockTypeName()) ?>"
                        href="javascript:void(0)"><img src="<?php echo $btIcon?>" /> <?php echo t($bt->getBlockTypeName())?></a>
                </li>
            <?php } ?>
        </ul>
    </section>

<?php } ?>

</div>

<script type="text/javascript">
    $(function() {
        $('#ccm-add-block-list').on('click', 'a', function() {
            ConcreteEvent.publish('AddBlockListAddBlock', {
                $launcher: $(this)
            });
            return false;
        });
    });
</script>