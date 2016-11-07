<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
$c = Page::getCurrentPage();
$ocID = $c->getCollectionID();
$fp = FilePermissions::getGlobal();
if ($fp->canAddFile() || $fp->canSearchFiles()) { ?>

<div class="ccm-dashboard-content-full" data-search="files">
<?php Loader::element('files/search', array('controller' => $searchController))?>
</div>

    <?php if ($fp->canAddFile()) { ?>
	<div id="ccm-file-manager-upload-prompt" class="ccm-file-manager-upload">
        <?php echo t("<strong>Upload Files</strong> / Click to Choose or Drag &amp; Drop. / ")?>
        <a href="<?php echo REL_DIR_FILES_TOOLS_REQUIRED?>/files/import"
           class="dialog-launch"
           dialog-width="500"
            dialog-height="500"
            dialog-modal="true"
            dialog-title="<?php echo t('Add Files')?>"><?php echo t('More Options')?></a>
        <input type="file" name="files[]" multiple="multiple" /></div>
<?php } ?>

<?php } else { ?>
	<p><?php echo t("You do not have access to the file manager.");?></p>
<?php } ?>
