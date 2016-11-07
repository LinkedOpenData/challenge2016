<?php defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\File\Exception\InvalidDimensionException;
use Concrete\Core\File\StorageLocation as FileStorageLocation;

$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>

<div class="ccm-ui">

    <div id="ccm-file-properties-response"></div>

    <?php
    $tabs = array(array('details', t('Details'), true));
    $tabs[] = array('versions', t('Versions'));
    $tabs[] = array('statistics', t('Statistics'));

    if (!$previewMode) {
        print Loader::helper('concrete/ui')->tabs($tabs);
    }
    ?>

    <?php if (!$previewMode) { ?>
    <div class="ccm-tab-content" id="ccm-tab-content-details" data-container="editable-fields">
        <?php } else { ?>
        <div class="container">
            <?php } ?>

            <section>

                <?php if (!$previewMode && $fp->canEditFileContents()) { ?>
                    <a href="#" class="btn pull-right btn-default btn-xs" data-action="rescan"><?php echo t('Rescan') ?></a>
                <?php } ?>

                <h4><?php echo t('Basic Properties') ?></h4>

                <?php if ($previewMode) {
                    $mode = 'preview';
                } ?>
                <?php Loader::element('files/properties', array('fv' => $fv, 'mode' => $mode))?>

            </section>

            <?php
            $attribs = FileAttributeKey::getImporterList($fv);
            $ft = $fv->getType();

            if (count($attribs) > 0) { ?>

            <section>
                <h4><?php echo t('%s File Properties', $ft) ?></h4>

                <?php

                Loader::element(
                    'attribute/editable_list',
                    array(
                        'attributes'           => $attribs,
                        'object'               => $f,
                        'saveAction'           => $controller->action('update_attribute'),
                        'clearAction'          => $controller->action('clear_attribute'),
                        'permissionsArguments' => $fp->canEditFileProperties(),
                        'permissionsCallback'  => function ($ak, $permissionsArguments) {
                            return $permissionsArguments;
                        }
                    )); ?>

                <?php } ?>
            </section>

            <?php
            $attribs = FileAttributeKey::getUserAddedList();

            if (count($attribs) > 0) { ?>

                <section>

                    <h4><?php echo t('Other Properties') ?></h4>

                    <?php Loader::element(
                        'attribute/editable_list',
                        array(
                            'attributes'           => $attribs,
                            'object'               => $f,
                            'saveAction'           => $controller->action('update_attribute'),
                            'clearAction'          => $controller->action('clear_attribute'),
                            'permissionsArguments' => $fp->canEditFileProperties(),
                            'permissionsCallback'  => function ($ak, $permissionsArguments) {
                                return $permissionsArguments;
                            }
                        )); ?>

                </section>

            <?php } ?>

            <section>

                <h4><?php echo t('File Preview') ?></h4>

                <div style="text-align: center">
                    <?php echo $fv->getDetailThumbnailImage() ?>
                </div>

            </section>

        </div>

        <?php if (!$previewMode) { ?>

            <div class="ccm-tab-content" id="ccm-tab-content-versions">

                <h4><?php echo t('Versions') ?></h4>

                <table border="0" cellspacing="0" width="100%" id="ccm-file-versions" class="table" cellpadding="0">
                    <tr>
                        <th>&nbsp;</th>
                        <th><?php echo t('Filename') ?></th>
                        <th><?php echo t('Title') ?></th>
                        <th><?php echo t('Comments') ?></th>
                        <th><?php echo t('Creator') ?></th>
                        <th><?php echo t('Added On') ?></th>
                        <?php if ($fp->canEditFileContents()) { ?>
                            <th>&nbsp;</th>
                        <?php } ?>
                    </tr>
                    <?php
                    $versions = $f->getVersionList();
                    foreach ($versions as $fvv) { ?>
                        <tr <?php if ($fvv->getFileVersionID() == $fv->getFileVersionID()) { ?> class="success" <?php } ?>
                            data-file-version-id="<?php echo $fvv->getFileVersionID() ?>">
                            <td style="text-align: center">
                                <input type="radio" name="fvID" value="<?php echo $fvv->getFileVersionID() ?>"
                                       <?php if ($fvv->getFileVersionID() == $fv->getFileVersionID()) { ?>checked<?php } ?> />
                            </td>
                            <td width="100">
                                <div style="width: 150px; word-wrap: break-word">
                                    <a href="<?php echo URL::to(
                                        '/ccm/system/dialogs/file/properties') ?>?fID=<?php echo $f->getFileID() ?>&amp;fvID=<?php echo $fvv->getFileVersionID() ?>"
                                       dialog-modal="false" dialog-width="630" dialog-height="450"
                                       dialog-title="<?php echo t('Preview File') ?>" class="dialog-launch">
                                        <?php echo h($fvv->getFilename()) ?>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div style="width: 150px; word-wrap: break-word">
                                    <?php echo h($fvv->getTitle()) ?>
                                </div>
                            </td>
                            <td><?php
                                $comments = $fvv->getVersionLogComments();
                                if (count($comments) > 0) {
                                    print t('Updated ');

                                    for ($i = 0; $i < count($comments); $i++) {
                                        print $comments[$i];
                                        if (count($comments) > ($i + 1)) {
                                            print ', ';
                                        }
                                    }

                                    print '.';
                                }
                                ?>
                            </td>
                            <td><?php echo $fvv->getAuthorName() ?></td>
                            <td><?php echo $dh->formatDateTime($fvv->getDateAdded(), true) ?></td>
                            <?php if ($fp->canEditFileContents()) { ?>
                                <td><a data-action="delete-version"
                                       data-file-version-id="<?php echo $fvv->getFileVersionID() ?>" href="javascript:void(0)"><i
                                            class="fa fa-trash-o"></i></a></td>
                            <?php } ?>
                        </tr>

                    <?php } ?>

                </table>

            </div>

            <div class="ccm-tab-content" id="ccm-tab-content-statistics">

                <?php
                $downloadStatistics = $f->getDownloadStatistics();
                ?>

                <section>
                    <h4><?php echo t('Total Downloads') ?></h4>

                    <div><?php echo $f->getTotalDownloads() ?></div>
                </section>

                <section>
                    <h4><?php echo t('Most Recent Downloads') ?></h4>
                    <table border="0" cellspacing="0" width="100%" class="table" cellpadding="0">
                        <tr>
                            <th><?php echo t('User') ?></th>
                            <th><?php echo t('Download Time') ?></th>
                            <th><?php echo t('File Version ID') ?></th>
                        </tr>
                        <?php

                        $downloadStatsCounter = 0;
                        foreach ($downloadStatistics as $download) {
                            $downloadStatsCounter++;
                            if ($downloadStatsCounter > 20) {
                                break;
                            }
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    $uID = intval($download['uID']);
                                    if (!$uID) {
                                        echo t('Anonymous');
                                    } else {
                                        $downloadUI = UserInfo::getById($uID);
                                        if ($downloadUI instanceof UserInfo) {
                                            echo $downloadUI->getUserName();
                                        } else {
                                            echo t('Deleted User');
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo $dh->formatDateTime($download['timestamp'], true) ?></td>
                                <td><?php echo intval($download['fvID']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </section>
            </div>
        <?php } ?>

    </div>
    <style type="text/css">
        #ccm-file-properties-response #ccm-notification-hud {
            position: relative;
            margin-bottom: 20px;
            top: 0px;
            left: 0px;
        }

        #ccm-file-properties-response #ccm-notification-hud .ccm-notification-inner {
            padding: 15px 10px 5px 60px;
            color: #fff;
        }

        #ccm-file-properties-response #ccm-notification-hud i {
            top: 2px;
            left: 8px;
            border: 0px;
        }

        tr.success a[data-action=delete-version] {
            display: none;
        }

        a[data-action=delete-version] {
            color: #333;
        }

        a[data-action=delete-version]:hover {
            color: #000;
            text-decoration: none;
        }

    </style>

    <script type="text/javascript">

        var ConcreteFilePropertiesDialog = function () {
            var my = this;
            $('div[data-container=editable-fields]').concreteEditableFieldContainer({
                url: '<?php echo $controller->action('save')?>'
            });
            my.setupFileVersionsTable();
            my.setupFileRescan();
        }

        ConcreteFilePropertiesDialog.prototype = {

            handleAjaxResponse: function (r, callback) {
                if (callback) {
                    callback(r);
                } else {
                    ConcreteAlert.notify({
                        'message': r.message,
                        'appendTo': '#ccm-file-properties-response'
                    });
                }
            },

            setupFileRescan: function () {
                var my = this;
                $('a[data-action=rescan]').on('click', function () {
                    $.concreteAjax({
                        url: '<?php echo URL::to('/ccm/system/file/rescan')?>',
                        data: {'fID': '<?php echo $f->getFileID()?>'},
                        success: function (r) {
                            my.handleAjaxResponse(r);
                        }
                    });
                    return false;
                });
            },

            setupFileVersionsTable: function () {
                var my = this;
                $versions = $('#ccm-file-versions');
                $versions.on('click', 'input[name=fvID]', function () {
                    var fvID = $(this).val();
                    $.concreteAjax({
                        url: '<?php echo URL::to('/ccm/system/file/approve_version')?>',
                        data: {'fID': '<?php echo $f->getFileID()?>', 'fvID': fvID},
                        success: function (r) {
                            my.handleAjaxResponse(r, function () {
                                $versions.find('tr[class=success]').removeClass();
                                $versions.find('tr[data-file-version-id=' + fvID + ']').addClass('success');
                            });
                        }
                    });
                });
                $versions.on('click', 'a[data-action=delete-version]', function () {
                    var fvID = $(this).attr('data-file-version-id');
                    $.concreteAjax({
                        url: '<?php echo URL::to('/ccm/system/file/delete_version')?>',
                        data: {'fID': '<?php echo $f->getFileID()?>', 'fvID': fvID},
                        success: function (r) {
                            my.handleAjaxResponse(r, function () {
                                var $row = $versions.find('tr[data-file-version-id=' + fvID + ']');
                                $row.queue(function () {
                                    $(this).addClass('animated fadeOutDown');
                                    $(this).dequeue();
                                }).delay(500).queue(function () {
                                    $(this).remove();
                                    $(this).dequeue();
                                });
                            });
                        }
                    });
                });

            }

        }

        <?php if (!$previewMode) { ?>
        $(function () {
            var dialog = new ConcreteFilePropertiesDialog();
        });
        <?php } ?>
    </script>
