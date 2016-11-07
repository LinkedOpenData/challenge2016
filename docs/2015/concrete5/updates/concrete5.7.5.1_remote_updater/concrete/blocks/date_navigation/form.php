<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<fieldset>
    <legend><?php echo t('Filtering')?></legend>
    <div class='form-group'>
        <label for='title' style="margin-bottom: 0px;"><?php echo t('By Parent Page')?>:</label>
        <div class="checkbox">
            <label>
                <input <?php if (intval($cParentID) > 0) { ?>checked<?php } ?> name="filterByParent" type="checkbox" value="1" />
                <?php echo t('Filter by Parent Page')?>
            </label>
        </div>
        <div id="ccm-block-related-pages-parent-page">
            <?php
            print Loader::helper('form/page_selector')->selectPage('cParentID', $cParentID);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label"><?php echo t('By Page Type') ?></label>
        <?php ?>
            <select class="form-control" name="ptID" id="selectPTID">
                <option value="0">** <?php echo t('All') ?> **</option>
                <?php
                foreach ($pagetypes as $ct) {
                    ?>
                    <option
                        value="<?php echo $ct->getPageTypeID() ?>" <?php if ($ptID == $ct->getPageTypeID()) { ?> selected <?php } ?>>
                        <?php echo $ct->getPageTypeDisplayName() ?>
                    </option>
                <?php
                }
                ?>
            </select>
        <?php ?>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo t("Results")?></legend>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input <?php if (intval($cTargetID) > 0) { ?>checked<?php } ?> name="redirectToResults" type="checkbox" value="1" />
                <?php echo t('Redirect to Different Page on Click')?>
            </label>
        </div>
        <div id="ccm-block-related-pages-search-page">
            <?php
            print Loader::helper('form/page_selector')->selectPage('cTargetID', $cTargetID);
            ?>
        </div>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo t('Formatting')?></legend>
    <div class="form-group">
        <label class="control-label" for="title"><?php echo t('Title')?></label>
        <input class="form-control" name="title" id="title" value="<?php echo $title?>" />
    </div>
</fieldset>


<script type="text/javascript">
    $(function() {
        $("input[name=filterByParent]").on('change', function() {
            if ($(this).is(":checked")) {
                $('#ccm-block-related-pages-parent-page').show();
            } else {
                $('#ccm-block-related-pages-parent-page').hide();
            }
        }).trigger('change');
        $("input[name=redirectToResults]").on('change', function() {
            if ($(this).is(":checked")) {
                $('#ccm-block-related-pages-search-page').show();
            } else {
                $('#ccm-block-related-pages-search-page').hide();
            }
        }).trigger('change');
    });
</script>
