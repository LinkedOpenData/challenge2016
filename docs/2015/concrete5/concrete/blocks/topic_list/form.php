<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<fieldset>
    <div class="form-group">
        <label class="control-label" for="modeSelect"><?php echo t('Mode')?></label>
        <select class="form-control" name="mode" id="modeSelect">
            <option value="S" <?php if ($mode == 'S') { ?>selected<?php } ?>><?php echo t('Search – Display a list of all topics for use on a search sidebar.')?></option>
            <option value="P" <?php if ($mode == 'P') { ?>selected<?php } ?>><?php echo t('Page – Display a list of topics for the current page.')?></option>
        </select>
    </div>
    <div class="form-group" data-row="mode-search">
        <label class="control-label" for="topicTreeIDSelect"><?php echo t('Topic Tree')?></label>
        <select class="form-control" name="topicTreeID" id="topicTreeIDSelect">
            <?php foreach($trees as $stree) { ?>
                <option value="<?php echo $stree->getTreeID()?>" <?php if ($tree->getTreeID() == $stree->getTreeID()) { ?>selected<?php } ?>><?php echo $stree->getTreeDisplayName()?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group" data-row="mode-page">
        <label class="control-label" for="attributeKeySelect"><?php echo t('Topic Attribute To Display')?></label>
        <select class="form-control" name="topicAttributeKeyHandle" id="attributeKeySelect">
            <?php foreach($attributeKeys as $attributeKey) { ?>
                <option value="<?php echo $attributeKey->getAttributeKeyHandle()?>" <?php if ($attributeKey->getAttributeKeyHandle() == $topicAttributeKeyHandle) { ?>selected<?php } ?>><?php echo $attributeKey->getAttributeKeyDisplayName()?></option>
            <?php } ?>
        </select>
    </div>

    <div class='form-group'>
        <label for='title' style="margin-bottom: 0px;"><?php echo t('Results Page')?>:</label>
        <div class="checkbox">
            <label for="ccm-search-block-external-target">
                <input id="ccm-search-block-external-target" <?php if (intval($cParentID) > 0) { ?>checked<?php } ?> name="externalTarget" type="checkbox" value="1" />
                <?php echo t('Post Results to a Different Page')?>
            </label>
        </div>
        <div id="ccm-search-block-external-target-page">
        <?php
        print Loader::helper('form/page_selector')->selectPage('cParentID', $cParentID);
        ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="title"><?php echo t('Title')?></label>
        <input class="form-control" name="title" id="title" value="<?php echo $title?>" />
    </div>

</fieldset>

<script type="text/javascript">
$(function() {
    $("select#modeSelect").on('change', function() {
        if ($(this).val() == 'S') {
            $('div[data-row=mode-page]').hide();
            $('div[data-row=mode-search]').show();
        } else {
            $('div[data-row=mode-search]').hide();
            $('div[data-row=mode-page]').show();
        }
    }).trigger('change');

   $("input[name=externalTarget]").on('change', function() {
       if ($(this).is(":checked")) {
           $('#ccm-search-block-external-target-page').show();
       } else {
           $('#ccm-search-block-external-target-page').hide();
       }
   }).trigger('change');
});
</script>
