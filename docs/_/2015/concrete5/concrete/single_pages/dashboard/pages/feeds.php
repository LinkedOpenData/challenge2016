<?php defined('C5_EXECUTE') or die("Access Denied.");?>

<?php if ($controller->getTask() == 'add'
    || $controller->getTask() == 'add_feed'
    || $controller->getTask() == 'edit'
    || $controller->getTask() == 'edit_feed'
    || $controller->getTask() == 'delete_feed') {

    $action = $view->action('add_feed');
    $token = 'add_feed';
    $pfTitle = '';
    $pfDescription = '';
    $pfHandle = '';
    $cParentID = null;
    $ptID = null;
    $pfIncludeAllDescendents = false;
    $pfDisplayAliases = false;
    $pfDisplayFeaturedOnly = false;
    $pfContentToDisplay = 'S';
    $pfAreaHandleToDisplay = 'Main';
    $button = t('Add');
    if (is_object($feed)) {
        $pfTitle = $feed->getTitle();
        $pfDescription = $feed->getDescription();
        $pfHandle = $feed->getHandle();
        $cParentID = $feed->getParentID();
        $ptID = $feed->getPageTypeID();
        $pfIncludeAllDescendents = $feed->getIncludeAllDescendents();
        $pfDisplayAliases = $feed->getDisplayAliases();
        $pfDisplayFeaturedOnly = $feed->getDisplayFeaturedOnly();
        $pfContentToDisplay = $feed->getTypeOfContentToDisplay();
        $pfAreaHandleToDisplay = $feed->getAreaHandleToDisplay();
        $action = $view->action('edit_feed', $feed->getID());
        $token = 'edit_feed';
        $button = t('Update');
    }
    ?>

    <div class="ccm-dashboard-header-buttons">
        <button data-dialog="delete-feed" class="btn btn-danger"><?php echo t("Delete Feed")?></button>
    </div>

    <?php if (is_object($feed)) { ?>

        <div style="display: none">
            <div id="ccm-dialog-delete-feed" class="ccm-ui">
                <form method="post" class="form-stacked" action="<?php echo $view->action('delete_feed')?>">
                    <?php echo Loader::helper("validation/token")->output('delete_feed')?>
                    <input type="hidden" name="pfID" value="<?php echo $feed->getID()?>" />
                    <p><?php echo t('Are you sure? This action cannot be undone.')?></p>
                </form>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
                    <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-feed form').submit()"><?php echo t('Delete Feed')?></button>
                </div>
            </div>
        </div>

    <?php } ?>

    <script type="text/javascript">
        $(function() {
            $('button[data-dialog=delete-feed]').on('click', function() {
                jQuery.fn.dialog.open({
                    element: '#ccm-dialog-delete-feed',
                    modal: true,
                    width: 320,
                    title: '<?php echo t("Delete Feed")?>',
                    height: 'auto'
                });
            });
        });
    </script>

    <form method="post" class="form-stacked" action="<?php echo $action?>">
        <?php echo $this->controller->token->output($token)?>
        <div class="form-group">
            <?php echo $form->label('pfTitle', t('Title'))?>
            <?php echo $form->text('pfTitle', $pfTitle)?>
        </div>
        <div class="form-group">
            <?php echo $form->label('pfHandle', t('Handle'))?>
            <?php echo $form->text('pfHandle', $pfHandle)?>
        </div>
        <div class="form-group">
            <?php echo $form->label('pfDescription', t('Description'))?>
            <?php echo $form->textarea('pfDescription', $pfDescription, array('rows' => 5))?>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Filter by Parent Page')?></label>
            <?php
            print Loader::helper('form/page_selector')->selectPage('cParentID', $cParentID);
            ?>
        </div>
        <div class="form-group">
            <?php echo $form->label('ptID', t('Filter By Page Type'))?>
            <?php echo $form->select('ptID', $pageTypes, $ptID)?>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Include All Sub-Pages of Parent?')?></label>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfIncludeAllDescendents', 1, $pfIncludeAllDescendents)?>
                    <?php echo t('Yes')?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfIncludeAllDescendents', 0, $pfIncludeAllDescendents)?>
                    <?php echo t('No')?>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Display Page Aliases?')?></label>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfDisplayAliases', 1, $pfDisplayAliases)?>
                    <?php echo t('Yes')?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfDisplayAliases', 0, $pfDisplayAliases)?>
                    <?php echo t('No')?>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Display Featured Only?')?></label>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfDisplayFeaturedOnly', 1, $pfDisplayFeaturedOnly)?>
                    <?php echo t('Yes')?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfDisplayFeaturedOnly', 0, $pfDisplayFeaturedOnly)?>
                    <?php echo t('No')?>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo t('Get Content From')?></label>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfContentToDisplay', 'S', $pfContentToDisplay)?>
                    <?php echo t('Short Description of Page')?>
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php echo $form->radio('pfContentToDisplay', 'A', $pfContentToDisplay)?>
                    <?php echo t('Pull Content from Area')?>
                </label>
            </div>
        </div>
        <div class="form-group" data-row="area" style="display: none">
            <?php echo $form->label('pfAreaHandleToDisplay', t('Select Area'))?>
            <?php echo $form->select('pfAreaHandleToDisplay', $areas, $pfAreaHandleToDisplay)?>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo URL::to('/dashboard/pages/feeds')?>" class="btn btn-default pull-left"><?php echo t("Cancel")?></a>
                <button class="pull-right btn btn-success" type="submit" ><?php echo $button?></button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        $(function() {
            $('input[name=pfContentToDisplay]').on('change', function() {
                var pfContentToDisplay = $('input[name=pfContentToDisplay]:checked').val();
                if (pfContentToDisplay == 'A') {
                    $('div[data-row=area]').show();
                } else {
                    $('div[data-row=area]').hide();
                }
            }).trigger("change");
        });

    </script>

<?php } else { ?>


    <div class="ccm-dashboard-header-buttons">
        <a href="<?php echo View::url('/dashboard/pages/feeds', 'add')?>" class="btn btn-primary"><?php echo t("Add Feed")?></a>
    </div>


    <?php if (count($feeds) > 0) { ?>
        <ul class="item-select-list">
            <?php foreach($feeds as $feed) { ?>
                <li><a href="<?php echo $view->action('edit', $feed->getID())?>"><i class="fa fa-rss"></i> <?php echo $feed->getTitle()?></a></li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p><?php echo t("You have not added any feeds.")?></p>
    <?php } ?>

<?php } ?>