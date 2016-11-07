<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
$c = Page::getCurrentPage();
$page_selector = Loader::helper('form/page_selector');
?>
<div class="row autonav-form">

    <div class="col-xs-6">

        <input type="hidden" name="autonavCurrentCID" value="<?php echo $c->getCollectionID() ?>"/>
        <input type="hidden" name="autonavPreviewPane"
               value="<?php echo Loader::helper('concrete/urls')->getBlockTypeToolsURL($bt) ?>/preview_pane"/>

        <fieldset>
        <legend><?php echo t('Settings') ?></legend>
        
        <div class="form-group">
            <label for="orderBy"><?php echo t('Page Order') ?></label>
            <select class="form-control" name="orderBy">
                <?php
                $order = $info['orderBy'];
                ?>
                <option value="display_asc" <?php echo $order === 'display_asc' ? 'selected' : '' ?>>
                    <?php echo t('in their sitemap order.') ?>
                </option>
                <option value="chrono_desc" <?php echo $order === 'chrono_desc' ? 'selected' : '' ?>>
                    <?php echo t('with the most recent first.') ?>
                </option>
                <option value="chrono_asc" <?php echo $order === 'chrono_asc' ? 'selected' : '' ?>>
                    <?php echo t('with the earliest first.') ?>
                </option>
                <option value="alpha_asc" <?php echo $order === 'alpha_asc' ? 'selected' : '' ?>>
                    <?php echo t('in alphabetical order.') ?>
                </option>
                <option value="alpha_desc" <?php echo $order === 'alpha_desc' ? 'selected' : '' ?>>
                    <?php echo t('in reverse alphabetical order.') ?>
                </option>
                <option value="display_desc" <?php echo $order === 'display_desc' ? 'selected' : '' ?>>
                    <?php echo t('in reverse sitemap order.') ?>
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="displayUnavailablePages"><?php echo t('Check Page Permissions') ?></label>
            <div class="checkbox">
                <label>
                <?php echo $form->checkbox('displayUnavailablePages', 1, $info['displayUnavailablePages']); ?>
                <?php echo t('Display links that may require login.'); ?>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="displayPages"><?php echo t('Begin Auto Nav') ?></label>
            <select name="displayPages" onchange="toggleCustomPage(this.value);" class="form-control">
                <option value="top"<?php if ($info['displayPages'] == 'top') { ?> selected<?php } ?>>
                    <?php echo t('at the top level'); ?>
                </option>
                <option value="second_level"<?php if ($info['displayPages'] == 'second_level') { ?> selected<?php } ?>>
                    <?php echo t('at the second level') ?>
                </option>
                <option value="third_level"<?php if ($info['displayPages'] == 'third_level') { ?> selected<?php } ?>>
                    <?php echo t('at the third level') ?>
                </option>
                <option value="above"<?php if ($info['displayPages'] == 'above') { ?> selected<?php } ?>>
                    <?php echo t('at the level above') ?>
                </option>
                <option value="current"<?php if ($info['displayPages'] == 'current') { ?> selected<?php } ?>>
                    <?php echo t('at the current level') ?>
                </option>
                <option value="below"<?php if ($info['displayPages'] == 'below') { ?> selected<?php } ?>>
                    <?php echo t('At the level below') ?>
                </option>
                <option value="custom"<?php if ($info['displayPages'] == 'custom') { ?> selected<?php } ?>>
                    <?php echo t('Beneath a particular page') ?>
                </option>
            </select>
        </div>

        <div class="form-group"
             id="ccm-autonav-page-selector"<?php if ($info['displayPages'] != 'custom') { ?> style="display: none"<?php } ?>>
            <?php echo $page_selector->selectPage('displayPagesCID', $info['displayPagesCID']); ?>
        </div>

        <div class="form-group">
            <label for="displaySubPages"><?php echo t('Sibling Pages') ?></label>

            <select class='form-control' name="displaySubPages" onchange="toggleSubPageLevels(this.value);">
                <option value="none"<?php if ($info['displaySubPages'] == 'none') { ?> selected<?php } ?>>
                    <?php echo t('None') ?>
                </option>
                <option value="relevant"<?php if ($info['displaySubPages'] == 'relevant') { ?> selected<?php } ?>>
                    <?php echo t('Relevant sub pages.') ?>
                </option>
                <option
                    value="relevant_breadcrumb"<?php if ($info['displaySubPages'] == 'relevant_breadcrumb') { ?> selected<?php } ?>>
                    <?php echo t('Display breadcrumb trail.') ?>
                </option>
                <option value="all"<?php if ($info['displaySubPages'] == 'all') { ?> selected<?php } ?>>
                    <?php echo t('Display all.') ?>
                </option>
            </select>

        </div>

        <div class="form-group">
            <label for="displaySubPages"><?php echo t('Page Levels') ?></label>

            <select class="form-control" id="displaySubPageLevels"
                    name="displaySubPageLevels" <?php if ($info['displaySubPages'] == 'none') { ?> disabled <?php } ?>
                    onchange="toggleSubPageLevelsNum(this.value);">
                <option value="enough"<?php if ($info['displaySubPageLevels'] == 'enough') { ?> selected<?php } ?>>
                    <?php echo t('Display sub pages to current.') ?></option>
                <option
                    value="enough_plus1"<?php if ($info['displaySubPageLevels'] == 'enough_plus1') { ?> selected<?php } ?>>
                    <?php echo t('Display sub pages to current +1.') ?></option>
                <option value="all"<?php if ($info['displaySubPageLevels'] == 'all') { ?> selected<?php } ?>>
                    <?php echo t('Display all.') ?></option>
                <option value="custom"<?php if ($info['displaySubPageLevels'] == 'custom') { ?> selected<?php } ?>>
                    <?php echo t('Display a custom amount.') ?></option>
            </select>

        </div>

        <div class="form-group"
             id="divSubPageLevelsNum"<?php if ($info['displaySubPageLevels'] != 'custom') { ?> style="display: none"<?php } ?>>
            <div class="input-group">
                <input type="text" name="displaySubPageLevelsNum" value="<?php echo $info['displaySubPageLevelsNum'] ?>"
                       class="form-control">
                <span class="input-group-addon"> <?php echo t('levels') ?></span>
            </div>
        </div>
        </fieldset>

        <div class="loader">
            <i class="fa fa-cog fa-spin"></i>
        </div>
    </div>

    <div class="col-xs-6">
        <fieldset>
        <legend><?php echo t('Included Pages') ?></legend>
        <div class="preview">
         	<div class="render"></div>
			<div class="cover"></div>
        </div>
        </fieldset>
    </div>

</div>

<style type="text/css">
    div.autonav-form div.loader {
        position: absolute;
        line-height: 34px;
    }
    div.autonav-form div.cover {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
    div.autonav-form div.render > ul ul {
        margin-left:25px;
        list-style-type: none;
    }
    div.autonav-form div.render li a {
        padding: 0;
        display: block;
    }
</style>
<script type="application/javascript">
    Concrete.event.publish('autonav.edit.open');
</script>
