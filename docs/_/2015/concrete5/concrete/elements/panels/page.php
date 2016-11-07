<?php
defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
use Concrete\Core\Attribute\Set as AttributeSet;

$cp = new Permissions($c);
$pk = PermissionKey::getByHandle('edit_page_properties');
$pk->setPermissionObject($c);
$asl = $pk->getMyAssignment();
$seoSet = AttributeSet::getByHandle('seo');
?>
<section>
    <header><?php echo t('Page Settings') ?></header>
    <?php if ($cp->canEditPageContents()
        || $cp->canEditPageTheme()
        || $cp->canEditPageProperties()
        || $cp->canEditPageTemplate()) { ?>

    <menu class="ccm-panel-page-basics">
        <?php
        $pagetype = PageType::getByID($c->getPageTypeID());
        if (is_object($pagetype) && $cp->canEditPageContents()) {
            ?>
            <li>
                <a href="#" data-launch-panel-detail="page-composer"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/composer') ?>"
                   data-panel-transition="fade">
                    <?php echo t('Composer') ?>
                </a>
            </li>
        <?php
        }

        if ($cp->canEditPageTheme() || $cp->canEditPageTemplate()) {
            ?>
            <li>
                <a href="#" data-launch-sub-panel-url="<?php echo URL::to('/ccm/system/panels/page/design') ?>"
                   data-launch-panel-detail="page-design"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/preview') ?>"
                   data-panel-transition="fade">
                    <?php echo t('Design') ?>
                </a>
            </li>
        <?php
        }

        if ($cp->canEditPageProperties() && is_object($seoSet)) {
            ?>
            <li>
                <a href="#" data-launch-panel-detail="page-seo"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/seo') ?>"
                   data-panel-transition="fade">
                    <?php echo t('SEO') ?>
                </a>
            </li>
        <?php
        }
        if ($c->getCollectionID() != HOME_CID && is_object($asl) && ($asl->allowEditPaths())) {
            ?>
            <li>
                <a href="#" data-launch-panel-detail="page-location"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/location') ?>"
                   data-panel-transition="fade">
                    <?php echo t('Location') ?>
                </a>
            </li>
        <?php
        }
        ?>
    </menu>
    <?php } ?>

    <menu>
        <?php
        if ($cp->canEditPageProperties()) {
            if (is_object($asl)) {
                $allowedAKIDs = $asl->getAttributesAllowedArray();
            }
            if (is_array($allowedAKIDs) && count($allowedAKIDs) > 0) {
                ?>
                <li>
                    <a href="#" data-launch-sub-panel-url="<?php echo URL::to('/ccm/system/panels/page/attributes') ?>"
                       data-launch-panel-detail="page-attributes"
                       data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/attributes') ?>"
                       data-panel-transition="fade">
                        <?php echo t('Attributes') ?>
                    </a>
                </li>
            <?php
            }
        }

        if ($cp->canEditPageSpeedSettings()) {
            ?>
            <li>
                <a href="#" data-launch-panel-detail="page-caching"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/caching') ?>"
                   data-panel-transition="fade">
                    <?php echo t('Caching') ?>
                </a>
            </li>
        <?php
        }

        if ($cp->canEditPagePermissions()) {
            ?>
            <li>
                <a href="#" data-launch-panel-detail="page-permissions"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/details/page/permissions') ?>"
                   data-panel-transition="fade">
                    <?php echo t('Permissions') ?>
                </a>
            </li>
        <?php
        }

        if ($cp->canViewPageVersions()) {
            ?>
            <li>
                <a href="#" data-launch-sub-panel-url="<?php echo URL::to('/ccm/system/panels/page/versions') ?>">
                    <?php echo t('Versions') ?>
                </a>
            </li>
        <?php
        }

        if ($cp->canPreviewPageAsUser() && Config::get('concrete.permissions.model') == 'advanced') {
            ?>
            <li>
                <a href="#" data-launch-sub-panel-url="<?php echo URL::to('/ccm/system/panels/page/preview_as_user') ?>"
                   data-launch-panel-detail="preview-page"
                   data-panel-detail-url="<?php echo URL::to('/ccm/system/panels/page/preview_as_user/preview') ?>"
                   data-panel-transition="fade">
                    <?php echo t('View as User') ?>
                </a>
            </li>
        <?php
        }

        if ($cp->canDeletePage()) {
            ?>
            <li>
                <a class="dialog-launch"
                   href="<?php echo URL::to('/ccm/system/dialogs/page/delete') ?>?cID=<?php echo $c->getCollectionID() ?>"
                   dialog-modal="true" dialog-title="<?php echo t('Delete Page') ?>" dialog-width="400" dialog-height="250">
                    <?php echo t('Delete Page') ?>
                </a>
            </li>
        <?php
        }
        ?>
    </menu>
</section>
