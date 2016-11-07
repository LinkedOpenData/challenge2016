<?php
defined('C5_EXECUTE') or die("Access Denied.");
$f = $fv->getFile();
$fp = new Permissions($f);
$dh = Core::make('date');
if (!isset($mode) || !$mode) {
    $mode = 'single';
}
?>
<?php if ($mode == 'single') { ?>
<div class="row">
    <div class="col-md-2"><p><?php echo t('ID') ?></p></div>
    <div class="col-md-10"><p><?php echo $fv->getFileID() ?> <span style="color: #afafaf">(<?php echo t(
                    'Version') ?> <?php echo $fv->getFileVersionID() ?>)</p></div>
</div>
<div class="row">
    <div class="col-md-2"><p><?php echo t('Filename') ?></p></div>
    <div class="col-md-10"><p><?php echo h($fv->getFileName()) ?></p></div>
</div>
<?php } ?>

<?php
$url = $fv->getURL();
?>
<div class="row">
    <div class="col-md-2"><p><?php echo t('URL to File') ?></p></div>
    <div class="col-md-10"><p style="overflow: hidden"><?php echo $url ?></p></div>
</div>
<?php if ($mode == 'single') { ?>
    <?php
    $oc = $f->getOriginalPageObject();
    if (is_object($oc)) {
        $fileManager = Page::getByPath('/dashboard/files/search');
        $ocName = $oc->getCollectionName();
        if (is_object($fileManager) && !$fileManager->isError()) {
            if ($fileManager->getCollectionID() == $oc->getCollectionID()) {
                $ocName = t('Dashboard File Manager');
            }
        }
        ?>
        <div class="row">
            <div class="col-md-2"><p><?php echo t('Page Added To') ?></p></div>
            <div class="col-md-10"><p><a href="<?php echo Loader::helper('navigation')->getLinkToCollection($oc) ?>"
                                        target="_blank"><?php echo $ocName ?></a></p></div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-2"><p><?php echo t('Type') ?></p></div>
        <div class="col-md-10"><p><?php echo $fv->getType() ?></p></div>
    </div>

<?php } ?>

<?php if ($fv->getTypeObject()->getGenericType() == \Concrete\Core\File\Type\Type::T_IMAGE) {
    try {
        $thumbnails = $fv->getThumbnails();
    } catch (InvalidDimensionException $e) {
        ?>
        <div class="row">

            <div class="col-md-2"><p><?php echo t('Thumbnails') ?></p></div>
            <div class="col-md-10">
                <p style="color:#cc3333">
                    <?php echo t('Invalid file dimensions, please rescan this file.') ?>
                    <?php if ($mode != 'preview' && $fp->canEditFileContents()) { ?>
                        <a href="#" class="btn pull-right btn-default btn-xs"
                           data-action="rescan"><?php echo t('Rescan') ?></a>
                    <?php } ?>
                </p>
            </div>
        </div>
    <?php
    } catch (\Exception $e) {
        ?>
        <div class="row">

            <div class="col-md-2"><p><?php echo t('Thumbnails') ?></p></div>
            <div class="col-md-10">
                <p style="color:#cc3333">
                    <?php echo t('Unknown error retrieving thumbnails, please rescan this file.') ?>
                    <?php if ($mode != 'preview' && $fp->canEditFileContents()) { ?>
                        <a href="#" class="btn pull-right btn-default btn-xs"
                           data-action="rescan"><?php echo t('Rescan') ?></a>
                    <?php } ?>
                </p>
            </div>
        </div>
    <?php
    }
    if ($thumbnails) {
        ?>
        <div class="row">
            <div class="col-md-2"><p><?php echo t('Thumbnails') ?></p></div>
            <div class="col-md-10"><p><a class="dialog-launch icon-link"
                                        dialog-title="<?php echo t('Thumbnail Images') ?>"
                                        dialog-width="90%" dialog-height="70%" href="<?php echo URL::to(
                        '/ccm/system/dialogs/file/thumbnails') ?>?fID=<?php echo $fv->getFileID() ?>&fvID=<?php echo $fv->getFileVersionID() ?>"><?php echo count(
                            $thumbnails) ?> <i class="fa fa-edit"></i></a></p></div>
        </div>
    <?php
    }
}
?>
<?php if ($mode == 'single') { ?>

    <div class="row">
        <div class="col-md-2"><p><?php echo t('Size') ?></p></div>
        <div class="col-md-10"><p><?php echo $fv->getSize() ?> (<?php echo t2(/*i18n: %s is a number */
                    '%s byte',
                    '%s bytes',
                    $fv->getFullSize(),
                    Loader::helper('number')->format($fv->getFullSize())) ?>)</p></div>
    </div>
    <div class="row">
        <div class="col-md-2"><p><?php echo t('Date Added') ?></p></div>
        <div class="col-md-10"><p><?php echo t(
                    'Added by <strong>%s</strong> on %s',
                    $fv->getAuthorName(),
                    $dh->formatDateTime($f->getDateAdded(), true)) ?></p></div>
    </div>
    <?php
    $fsl = $f->getFileStorageLocationObject();
    if (is_object($fsl)) { ?>
        <div class="row">
            <div class="col-md-2"><p><?php echo t('Storage Location') ?></p></div>
            <div class="col-md-10"><p><?php echo $fsl->getDisplayName() ?></div>
        </div>
    <?php } ?>
<?php } ?>
<div class="row">
    <div class="col-md-2"><p><?php echo t('Title') ?></p></div>
    <div class="col-md-10"><p><span
                <?php if ($fp->canEditFileProperties()) { ?>data-editable-field-type="xeditable"
                data-type="text" data-name="fvTitle"<?php } ?>><?php echo h($fv->getTitle()) ?></span></p></div>
</div>
<div class="row">
    <div class="col-md-2"><p><?php echo t('Description') ?></p></div>
    <div class="col-md-10"><p><span
                <?php if ($fp->canEditFileProperties()) { ?>data-editable-field-type="xeditable"
                data-type="textarea" data-name="fvDescription"<?php } ?>><?php echo h(
                    $fv->getDescription()) ?></span></p></div>
</div>
<div class="row">
    <div class="col-md-2"><p><?php echo t('Tags') ?></p></div>
    <div class="col-md-10"><p><span
                <?php if ($fp->canEditFileProperties()) { ?>data-editable-field-type="xeditable"
                data-type="textarea" data-name="fvTags"<?php } ?>><?php echo h($fv->getTags()) ?></span></p></div>
</div>
