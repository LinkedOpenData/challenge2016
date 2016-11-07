<?php
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\Workflow\Progress\PageProgress as PageWorkflowProgress;
use \Concrete\Core\Block\View\BlockView;
if ($controller->getTask() == 'view_details') {

    $cpc = new Permissions($stack);
    $showApprovalButton = false;
    $hasPendingPageApproval = false;
    $workflowList = PageWorkflowProgress::getList($stack);
    foreach($workflowList as $wl) {
        $wr = $wl->getWorkflowRequestObject();
        $wrk = $wr->getWorkflowRequestPermissionKeyObject();
        if ($wrk->getPermissionKeyHandle() == 'approve_page_versions') {
            $hasPendingPageApproval = true;
            break;
        }
    }

    if (!$hasPendingPageApproval) {
        $vo = $stack->getVersionObject();
        if ($cpc->canApprovePageVersions()) {
            $publishTitle = t('Approve Changes');
            $pk = PermissionKey::getByHandle('approve_page_versions');
            $pk->setPermissionObject($stack);
            $pa = $pk->getPermissionAccessObject();
            if (is_object($pa) && count($pa->getWorkflows()) > 0) {
                $publishTitle = t('Submit to Workflow');
            }
            $showApprovalButton = true;
        }
    }

    $isGlobalArea = false;
    if ($stack->getStackType() == Stack::ST_TYPE_GLOBAL_AREA) {
        $isGlobalArea = true;
    }

    ?>

    <div class="ccm-dashboard-header-buttons">
        <?php if ($isGlobalArea) { ?>
        <a href="<?php echo URL::to('/dashboard/blocks/stacks/view_global_areas')?>" data-dialog="add-stack" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?php echo t("Back to Global Areas")?></a>
        <?php } else { ?>
        <a href="<?php echo URL::to('/dashboard/blocks/stacks')?>" data-dialog="add-stack" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?php echo t("Back to Stacks")?></a>
        <?php } ?>
    </div>

    <p class="lead"><?php echo $stack->getCollectionName()?></p>

    <nav class="navbar navbar-default">
    <div class="container-fluid">
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo t('Add Block')?></i></a>
            <ul class="dropdown-menu">
                <li><a class="dialog-launch" dialog-modal="false" dialog-width="550" dialog-height="380" dialog-title="<?php echo t('Add Block')?>" href="<?php echo URL::to('/ccm/system/dialogs/page/add_block_list')?>?cID=<?php echo $stack->getCollectionID()?>&arHandle=<?php echo STACKS_AREA_NAME?>"><?php echo t('Add Block')?></a></li>
                <li><a class="dialog-launch" dialog-modal="false" dialog-width="550" dialog-height="380" dialog-title="<?php echo t('Paste From Clipboard')?>" href="<?php echo URL::to('/ccm/system/dialogs/page/clipboard')?>?cID=<?php echo $stack->getCollectionID()?>&arHandle=<?php echo STACKS_AREA_NAME?>"><?php echo t('Paste From Clipboard')?></a></li>
            </ul>
        </li>

        <li><a dialog-width="640" dialog-height="340" class="dialog-launch" id="stackVersions" dialog-title="<?php echo t('Version History')?>" href="<?php echo URL::to('/ccm/system/panels/page/versions')?>?cID=<?php echo $stack->getCollectionID()?>"><?php echo t('Version History')?></a></li>
        <?php if ($cpc->canEditPageProperties() && $stack->getStackType() != \Concrete\Core\Page\Stack\Stack::ST_TYPE_GLOBAL_AREA) { ?>
            <li><a href="<?php echo $view->action('rename', $stack->getCollectionID())?>"><?php echo t('Rename')?></a></li>
        <?php } ?>
        <?php if ($cpc->canEditPagePermissions() && Config::get('concrete.permissions.model') == 'advanced') { ?>
            <li><a dialog-width="580" class="dialog-launch" dialog-append-buttons="true" dialog-height="420" dialog-title="<?php echo t('Stack Permissions')?>" id="stackPermissions" href="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/edit_area_popup?cID=<?php echo $stack->getCollectionID()?>&arHandle=<?php echo STACKS_AREA_NAME?>&atask=groups"><?php echo t('Permissions')?></a></li>
        <?php } ?>

        <?php if ($cpc->canMoveOrCopyPage() && $stack->getStackType() != \Concrete\Core\Page\Stack\Stack::ST_TYPE_GLOBAL_AREA) { ?>
            <li><a href="<?php echo $view->action('duplicate', $stack->getCollectionID())?>" style="margin-right: 4px;"><?php echo t('Duplicate Stack')?></a></li>
        <?php } ?>
        <?php if ($cpc->canDeletePage()) { ?>
            <?php if ($stack->getStackType() == \Concrete\Core\Page\Stack\Stack::ST_TYPE_GLOBAL_AREA) { ?>
                <li><a href="javascript:void(0)" data-dialog="delete-stack"><span class="text-danger"><?php echo t('Clear Global Area')?></span></a></li>
            <?php } else { ?>
                <li><a href="javascript:void(0)" data-dialog="delete-stack"><span class="text-danger"><?php echo t('Delete Stack')?></span></a></li>
            <?php } ?>
        <?php } ?>
    </ul>
    <?php if ($showApprovalButton) { ?>
    <ul class="nav navbar-nav navbar-right">
        <li id="ccm-stack-list-approve-button" class="navbar-form" <?php if ($vo->isApproved()) { ?> style="display: none;" <?php } ?>>
            <button class="btn btn-success" onclick="window.location.href='<?php echo URL::to('/dashboard/blocks/stacks', 'approve_stack', $stack->getCollectionID(), $token->generate('approve_stack'))?>'"><?php echo $publishTitle?></button>
        </li>
    </ul>
    <?php } ?>
    </div>
    </nav>

    <div id="ccm-stack-container">

    <?php
    $a = Area::get($stack, STACKS_AREA_NAME);
    $a->forceControlsToDisplay();
    Loader::element('block_area_header', array('a' => $a));

    foreach($blocks as $b) {
        $bv = new BlockView($b);
        $bv->setAreaObject($a);
        $p = new Permissions($b);
        if ($p->canViewBlock()) {
            $bv->render('view');
        }
    }
    ?>

    </div>
    </div>
    </div>

    <div style="display: none">
        <div id="ccm-dialog-delete-stack" class="ccm-ui">
            <form method="post" class="form-stacked" style="padding-left: 0px" action="<?php echo $view->action('delete_stack')?>">
                <?php echo Loader::helper("validation/token")->output('delete_stack')?>
                <input type="hidden" name="stackID" value="<?php echo $stack->getCollectionID()?>" />
                <p><?php echo t('Are you sure? This action cannot be undone.')?></p>
            </form>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-stack form').submit()"><?php echo t('Delete Stack')?></button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var showApprovalButton = function() {
            $('#ccm-stack-list-approve-button').show().addClass("animated fadeIn");
        };

        $(function() {
            var editor = new Concrete.EditMode({notify: false}), ConcreteEvent = Concrete.event;


            ConcreteEvent.on('ClipboardAddBlock', function(event, data) {
                var area = editor.getAreaByID(<?php echo $a->getAreaID()?>);
                block = new Concrete.DuplicateBlock(data.$launcher, editor);
                block.addToDragArea(_.last(area.getDragAreas()));
                return false;
            });

            ConcreteEvent.on('AddBlockListAddBlock', function(event, data) {
                var area = editor.getAreaByID(<?php echo $a->getAreaID()?>);
                blockType = new Concrete.BlockType(data.$launcher, editor);
                blockType.addToDragArea(_.last(area.getDragAreas()));
                return false;
            });

            ConcreteEvent.on('EditModeAddClipboardComplete', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            ConcreteEvent.on('EditModeAddBlockComplete', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            ConcreteEvent.on('EditModeUpdateBlockComplete', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            ConcreteEvent.on('EditModeBlockDelete', function(event, data) {
                showApprovalButton();
                _.defer(function() {
                    Concrete.getEditMode().scanBlocks();
                });
            });

            $('a[data-dialog=delete-stack]').on('click', function() {
                jQuery.fn.dialog.open({
                    element: '#ccm-dialog-delete-stack',
                    modal: true,
                    width: 320,
                    title: '<?php echo t("Delete Stack")?>',
                    height: 'auto'
                });
            });
        });
    </script>

<?php } else if ($this->controller->getTask() == 'duplicate') {
    $sv = CollectionVersion::get($stack, 'ACTIVE');
    ?>

    <form name="duplicate_form" action="<?php echo $view->action('duplicate', $stack->getCollectionID())?>" method="POST">
        <?php echo Loader::helper("validation/token")->output('duplicate_stack')?>
        <legend><?php echo t('Duplicate Stack')?></legend>
        <div class="form-group">
            <?php echo $form->label('stackName', t("Name"))?>
            <?php echo $form->text('stackName', $stack->getStackName())?>
        </div>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo $view->action('view_details', $stack->getCollectionID())?>" class="btn btn-default"><?php echo t('Cancel')?></a>
                <button type="submit" class="btn pull-right btn-primary"><?php echo t('Duplicate')?></button>
            </div>
        </div>
    </form>

<?php } else if ($this->controller->getTask() == 'rename') {

    $sv = CollectionVersion::get($stack, 'ACTIVE');
    ?>

    <form action="<?php echo $view->action('rename', $stack->getCollectionID())?>" method="POST">
        <legend><?php echo t('Rename Stack')?></legend>
        <?php echo Loader::helper("validation/token")->output('rename_stack')?>
        <div class="form-group">
            <?php echo $form->label('stackName', t("Name"))?>
            <?php echo $form->text('stackName', $stack->getStackName())?>
        </div>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo $view->action('view_details', $stack->getCollectionID())?>" class="btn btn-default"><?php echo t('Cancel')?></a>
                <button type="submit" class="btn pull-right btn-primary"><?php echo t('Rename')?></button>
            </div>
        </div>
    </form>

<?php } else { ?>

    <?php if (count($stacks) > 0) { ?>
        <ul class="item-select-list" id="ccm-stack-list">
        <?php foreach($stacks as $st) {
            $sv = CollectionVersion::get($st, 'ACTIVE');
            ?>

            <li id="stID_<?php echo $st->getCollectionID()?>">
                <?php if ($canMoveStacks) { ?><i class="ccm-item-select-list-sort"></i><?php } ?>
                <a href="<?php echo $view->url('/dashboard/blocks/stacks', 'view_details', $st->getCollectionID())?>">
                    <i class="fa fa-bars"></i> <?php echo $sv->getVersionName()?>
                </a>
            </li>
        <?php } ?>
        </ul>
        <?php
    } else {
        print '<p>';
        if ($controller->getTask() == 'view_global_areas') {
            print t('No global areas have been added.');
        } else {
            print t('No stacks have been added.');
        }
        print '</p>';
    }
    ?>


    <div class="ccm-dashboard-header-buttons">
        <button type="button" class="btn btn-default" data-toggle="dropdown">
            <?php if ($controller->getTask() == 'view_global_areas') { ?>
                <?php echo t('View Global Areas')?>
            <?php } else { ?>
                <?php echo t('View Stacks')?>
            <?php } ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo $controller->action('view')?>"><?php echo t('View Stacks')?></a></li>
            <li><a href="<?php echo $controller->action('view_global_areas')?>"><?php echo t('View Global Areas')?></a></li>
        </ul>
        <?php if ($controller->getTask() != 'view_global_areas') { ?>
            <a href="javascript:void(0)" data-dialog="add-stack" class="btn btn-primary"><?php echo t("Add Stack")?></a>
        <?php } ?>
    </div>

    <div style="display: none">
        <div id="ccm-dialog-add-stack" class="ccm-ui">
            <form method="post" class="form-stacked" style="padding-left: 0px" action="<?php echo $view->action('add_stack')?>">
                <?php echo Loader::helper("validation/token")->output('add_stack')?>
                <div class="form-group">
                    <?php echo Loader::helper("form")->label('stackName', t('Stack Name'))?>
                    <?php echo Loader::helper('form')->text('stackName')?>
                </div>
            </form>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
                <button class="btn btn-primary pull-right" onclick="$('#ccm-dialog-add-stack form').submit()"><?php echo t('Add Stack')?></button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(function() {

        $('a[data-dialog=add-stack]').on('click', function() {
            jQuery.fn.dialog.open({
                element: '#ccm-dialog-add-stack',
                modal: true,
                width: 320,
                title: '<?php echo t("Add Stack")?>',
                height: 'auto'
            });
        });
        <?php if ($canMoveStacks) { ?>
        $("ul#ccm-stack-list").sortable({
            handle: "i.ccm-item-select-list-sort",
            cursor: "move",
            axis: "y",
            opacity: 0.5,
            stop: function() {
                var pagelist = $(this).sortable("serialize");
                $.ajax({
                    dataType: "json",
                    type: "post",
                    url: "<?php echo $sortURL?>",
                    data: pagelist,
                    success: function(r) {

                    }
                });
            }
        });
        <?php } ?>

    });
    </script>

<?php } ?>
