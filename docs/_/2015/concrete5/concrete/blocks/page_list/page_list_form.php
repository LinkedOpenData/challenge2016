<?php defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
$form = Loader::helper('form/page_selector');
?>
<div class="row pagelist-form">
    <div class="col-xs-6">

        <input type="hidden" name="pageListToolsDir" value="<?php echo Loader::helper('concrete/urls')->getBlockTypeToolsURL($bt) ?>/"/>

        <fieldset>
        <legend><?php echo t('Settings') ?></legend>
        
        <div class="form-group">
            <label class='control-label'><?php echo t('Number of Pages to Display') ?></label>
            <input type="text" name="num" value="<?php echo $num ?>" class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Page Type') ?></label>
            <?php
            $ctArray = PageType::getList();

            if (is_array($ctArray)) {
                ?>
                <select class="form-control" name="ptID" id="selectPTID">
                    <option value="0">** <?php echo t('All') ?> **</option>
                    <?php
                    foreach ($ctArray as $ct) {
                        ?>
                        <option
                            value="<?php echo $ct->getPageTypeID() ?>" <?php if ($ptID == $ct->getPageTypeID()) { ?> selected <?php } ?>>
                            <?php echo $ct->getPageTypeDisplayName() ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            <?php
            }
            ?>
        </div>
		</fieldset>
		
		<fieldset>
            <legend><?php echo t('Topics') ?></legend>
        <div class="radio">
            <label>
                <input type="radio" name="topicFilter" id="topicFilter"
                       value="" <?php if (!$filterByRelated && !$filterByCustomTopic) { ?> checked<?php } ?> />
                <?php echo t('No topic filtering') ?>
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="topicFilter" id="topicFilterCustom"
                       value="custom" <?php if ($filterByCustomTopic) { ?> checked<?php } ?>>
                <?php echo t('Custom Topic') ?>
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="topicFilter" id="topicFilterRelated"
                       value="related" <?php if ($filterByRelated) { ?> checked<?php } ?> >
                <?php echo t('Related Topic') ?>
            </label>
        </div>
        <div data-row="custom-topic">
            <div class="form-group">
                <select class="form-control" name="customTopicAttributeKeyHandle" id="customTopicAttributeKeyHandle">
                    <option value=""><?php echo t('Choose topics attribute.')?></option>
                    <?php foreach($attributeKeys as $attributeKey) {
                        $attributeController = $attributeKey->getController();
                        ?>
                        <option data-topic-tree-id="<?php echo $attributeController->getTopicTreeID()?>" value="<?php echo $attributeKey->getAttributeKeyHandle()?>" <?php if ($attributeKey->getAttributeKeyHandle() == $customTopicAttributeKeyHandle) { ?>selected<?php } ?>><?php echo $attributeKey->getAttributeKeyDisplayName()?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="tree-view-container">
                <div class="tree-view-template">
                </div>
            </div>
            <input type="hidden" name="customTopicTreeNodeID" value="<?php echo $customTopicTreeNodeID ?>">

        </div>
        <div data-row="related-topic">
            <div class="form-group">
                <span class="help-block"><?php echo t('Allows other blocks like the topic list block to pass search criteria to this page list block.')?></span>
            <select class="form-control" name="relatedTopicAttributeKeyHandle" id="relatedTopicAttributeKeyHandle">
                <option value=""><?php echo t('Choose topics attribute.')?></option>
                <?php foreach($attributeKeys as $attributeKey) { ?>
                    <option value="<?php echo $attributeKey->getAttributeKeyHandle()?>" <?php if ($attributeKey->getAttributeKeyHandle() == $relatedTopicAttributeKeyHandle) { ?>selected<?php } ?>><?php echo $attributeKey->getAttributeKeyDisplayName()?></option>
                <?php } ?>
            </select>
        </div>
        </fieldset>

        <fieldset>
        <legend><?php echo t('Other Filters') ?></legend>
        <div class="checkbox">
            <label>
                <input <?php if (!is_object($featuredAttribute)) { ?> disabled <?php } ?> type="checkbox" name="displayFeaturedOnly"
                                                                       value="1" <?php if ($displayFeaturedOnly == 1) { ?> checked <?php } ?>
                                                                       style="vertical-align: middle"/>
                <?php echo t('Featured pages only.') ?>
            </label>
            <?php if (!is_object($featuredAttribute)) { ?>
                <span class="help-block"><?php echo
                    t(
                        '(<strong>Note</strong>: You must create the "is_featured" page attribute first.)'); ?></span>
            <?php } ?>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="displayAliases"
                       value="1" <?php if ($displayAliases == 1) { ?> checked <?php } ?> />
                <?php echo t('Display page aliases.') ?>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="enableExternalFiltering" value="1" <?php if ($enableExternalFiltering) { ?>checked<?php } ?> />
                <?php echo t('Enable Other Blocks to Filter This Page List.') ?>
            </label>
        </div>

		</fieldset>
		
		<fieldset>
        <legend><?php echo t('Pagination') ?></legend>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="paginate" value="1" <?php if ($paginate == 1) { ?> checked <?php } ?> />
                <?php echo t('Display pagination interface if more items are available than are displayed.') ?>
            </label>
        </div>
		</fieldset>
		
		<fieldset>
        <legend><?php echo t('Location') ?></legend>
        <div class="radio">
            <label>
                <input type="radio" name="cParentID" id="cEverywhereField"
                       value="0" <?php if ($cParentID == 0) { ?> checked<?php } ?> />
                <?php echo t('Everywhere') ?>
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="cParentID" id="cThisPageField"
                       value="<?php echo $c->getCollectionID() ?>" <?php if ($cParentID == $c->getCollectionID() || $cThis) { ?> checked<?php } ?>>
                <?php echo t('Beneath this page') ?>
            </label>
         </div>
        <div class="radio">
            <label>
                <input type="radio" name="cParentID" id="cOtherField"
                       value="OTHER" <?php if ($isOtherPage) { ?> checked<?php } ?>>
                <?php echo t('Beneath another page') ?>
            </label>
        </div>

        <div class="ccm-page-list-page-other" <?php if (!$isOtherPage) { ?> style="display: none" <?php } ?>>

            <div class="form-group">
                <?php echo $form->selectPage('cParentIDValue', $isOtherPage ? $cParentID : false); ?>
            </div>
        </div>

        <div class="ccm-page-list-all-descendents"
             style="<?php echo (!$isOtherPage && !$cThis) ? ' display: none;' : ''; ?>">
            <div class="form-group">
                <div class="checkbox">
                <label>
                    <input type="checkbox" name="includeAllDescendents" id="includeAllDescendents"
                           value="1" <?php echo $includeAllDescendents ? 'checked="checked"' : '' ?> />
                    <?php echo t('Include all child pages') ?>
                </label>
                </div>
            </div>
        </div>
		</fieldset>
		
		<fieldset>
        <legend><?php echo t('Sort') ?></legend>
        <div class="form-group">
            <select name="orderBy" class="form-control">
                <option value="display_asc" <?php if ($orderBy == 'display_asc') { ?> selected <?php } ?>>
                    <?php echo t('Sitemap order') ?>
                </option>
                <option value="chrono_desc" <?php if ($orderBy == 'chrono_desc') { ?> selected <?php } ?>>
                    <?php echo t('Most recent first') ?>
                </option>
                <option value="chrono_asc" <?php if ($orderBy == 'chrono_asc') { ?> selected <?php } ?>>
                    <?php echo t('Earliest first') ?>
                </option>
                <option value="alpha_asc" <?php if ($orderBy == 'alpha_asc') { ?> selected <?php } ?>>
                    <?php echo t('Alphabetical order') ?>
                </option>
                <option value="alpha_desc" <?php if ($orderBy == 'alpha_desc') { ?> selected <?php } ?>>
                    <?php echo t('Reverse alphabetical order') ?>
                </option>
                <option value="random" <?php if ($orderBy == 'random') { ?> selected <?php } ?>>
                    <?php echo t('Random') ?>
                </option>
            </select>
        </div>
		</fieldset>
		
		<fieldset>
        <legend><?php echo t('Output') ?></legend>
        <div class="form-group">
            <label class="control-label"><?php echo t('Provide RSS Feed') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="rss" class="rssSelector"
                           value="0" <?php echo (is_object($rssFeed) ? "" : "checked=\"checked\"") ?>/> <?php echo t('No') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input id="ccm-pagelist-rssSelectorOn" type="radio" name="rss" class="rssSelector"
                           value="1" <?php echo (is_object($rssFeed) ? "checked=\"checked\"" : "") ?>/> <?php echo t('Yes') ?>
                </label>
             </div>
            <div id="ccm-pagelist-rssDetails" <?php echo (is_object($rssFeed) ? "" : "style=\"display:none;\"") ?>>
                <?php if (is_object($rssFeed)) { ?>
                    <?php echo t('RSS Feed can be found here: <a href="%s" target="_blank">%s</a>', $rssFeed->getFeedURL(), $rssFeed->getFeedURL())?>
                <?php } else { ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo t('RSS Feed Title') ?></label>
                        <input class="form-control" id="ccm-pagelist-rssTitle" type="text" name="rssTitle"
                               value=""/>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo t('RSS Feed Description') ?></label>
                        <textarea name="rssDescription" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo t('RSS Feed Location') ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo URL::to('/rss')?>/</span>
                            <input type="text" name="rssHandle" value="" />
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Include Page Name') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="includeName"
                           value="0" <?php echo ($includeName ? "" : "checked=\"checked\"") ?>/> <?php echo t('No') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="includeName"
                           value="1" <?php echo ($includeName ? "checked=\"checked\"" : "") ?>/> <?php echo t('Yes') ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Include Page Description') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="includeDescription"
                           value="0" <?php echo ($includeDescription ? "" : "checked=\"checked\"") ?>/> <?php echo t('No') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="includeDescription"
                           value="1" <?php echo ($includeDescription ? "checked=\"checked\"" : "") ?>/> <?php echo t('Yes') ?>
                </label>
            </div>
            <div class="ccm-page-list-truncate-description" <?php echo ($includeDescription ? "" : "style=\"display:none;\"") ?>>
                <label class="control-label"><?php echo t('Display Truncated Description')?></label>
                <div class="input-group">
                <span class="input-group-addon">
                    <input id="ccm-pagelist-truncateSummariesOn" name="truncateSummaries" type="checkbox"
                           value="1" <?php echo ($truncateSummaries ? "checked=\"checked\"" : "") ?> />
                </span>
                    <input class="form-control" id="ccm-pagelist-truncateChars" <?php echo ($truncateSummaries ? "" : "disabled=\"disabled\"") ?>
                           type="text" name="truncateChars" size="3" value="<?php echo intval($truncateChars) ?>" />
                <span class="input-group-addon">
                    <?php echo t('characters') ?>
                </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Include Public Page Date') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="includeDate"
                           value="0" <?php echo ($includeDate ? "" : "checked=\"checked\"") ?>/> <?php echo t('No') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="includeDate"
                           value="1" <?php echo ($includeDate ? "checked=\"checked\"" : "") ?>/> <?php echo t('Yes') ?>
                </label>
            </div>
            <span class="help-block"><?php echo t('This is usually the date the page is created. It can be changed from the page attributes panel.')?></span>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Display Thumbnail Image') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="displayThumbnail"
                           <?php echo (!is_object($thumbnailAttribute) ? 'disabled ' : '')?>
                           value="0" <?php echo ($displayThumbnail ? "" : "checked=\"checked\"") ?>/> <?php echo t('No') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="displayThumbnail"
                        <?php echo (!is_object($thumbnailAttribute) ? 'disabled ' : '')?>
                           value="1" <?php echo ($displayThumbnail ? "checked=\"checked\"" : "") ?>/> <?php echo t('Yes') ?>
                </label>
            </div>
            <?php if (!is_object($thumbnailAttribute)) { ?>
                <div class="help-block">
                <?php echo t('You must create an attribute with the \'thumbnail\' handle in order to use this option.')?>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Use Different Link than Page Name') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="useButtonForLink"
                           value="0" <?php echo ($useButtonForLink ? "" : "checked=\"checked\"") ?>/> <?php echo t('No') ?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="useButtonForLink"
                           value="1" <?php echo ($useButtonForLink ? "checked=\"checked\"" : "") ?>/> <?php echo t('Yes') ?>
                </label>
            </div>
            <div class="ccm-page-list-button-text" <?php echo ($useButtonForLink ? "" : "style=\"display:none;\"") ?>>
                <div class="form-group">
                    <label class="control-label"><?php echo t('Link Text') ?></label>
                    <input class="form-control" type="text" name="buttonLinkText" value="<?php echo $buttonLinkText?>" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Title of Page List') ?></label>
            <input type="text" class="form-control" name="pageListTitle" value="<?php echo $pageListTitle?>" />
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo t('Message to Display When No Pages Listed.') ?></label>
            <textarea class="form-control" name="noResultsMessage"><?php echo $noResultsMessage?></textarea>
        </div>
        <fieldset>


        <div class="loader">
            <i class="fa fa-cog fa-spin"></i>
        </div>
    </div>

    <div class="col-xs-6" id="ccm-tab-content-page-list-preview">
        <fieldset>
        <legend><?php echo t('Included Pages') ?></legend>
        <div class="preview">
            	<div class="render">

            	</div>
            	<div class="cover"></div>
        </div>
         </fieldset>
    </div>

</div>

<style type="text/css">
    div.pagelist-form div.loader {
        position: absolute;
        line-height: 34px;
    }

    div.pagelist-form div.cover {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    div.pagelist-form div.render .ccm-page-list-title {
        font-size: 12px;
        font-weight: normal;
    }

    div.pagelist-form label.checkbox,
    div.pagelist-form label.radio {
        font-weight: 300;
    }

</style>
<script type="application/javascript">
    Concrete.event.publish('pagelist.edit.open');
    $(function() {
        $('input[name=topicFilter]').on('change', function() {
            if ($(this).val() == 'related') {
                $('div[data-row=related-topic]').show();
                $('div[data-row=custom-topic]').hide();
            } else if ($(this).val() == 'custom') {
                $('div[data-row=custom-topic]').show();
                $('div[data-row=related-topic]').hide();
            } else {
                $('div[data-row=related-topic]').hide();
                $('div[data-row=custom-topic]').hide();
            }
        });

        var treeViewTemplate = $('.tree-view-template');

        $('select[name=customTopicAttributeKeyHandle]').on('change', function() {
            var toolsURL = '<?php echo Loader::helper('concrete/urls')->getToolsURL('tree/load'); ?>';
            var chosenTree = $(this).find('option:selected').attr('data-topic-tree-id');
            $('.tree-view-template').remove();
            if (!chosenTree) {
                return;
            }
            $('.tree-view-container').append(treeViewTemplate);
            $('.tree-view-template').ccmtopicstree({
                'treeID': chosenTree,
                'chooseNodeInForm': true,
                'selectNodesByKey': [<?php echo intval($customTopicTreeNodeID)?>],
                'onSelect' : function(select, node) {
                    if (select) {
                        $('input[name=customTopicTreeNodeID]').val(node.data.key);
                    } else {
                        $('input[name=customTopicTreeNodeID]').val('');
                    }
                }
            });
        });
        $('input[name=topicFilter]:checked').trigger('change');
        if ($('#topicFilterCustom').is(':checked')) {
            $('select[name=customTopicAttributeKeyHandle]').trigger('change');
        }
    });

</script>

