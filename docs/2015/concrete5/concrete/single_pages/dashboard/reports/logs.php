<?php
defined('C5_EXECUTE') or die("Access Denied.");
$valt = Loader::helper('validation/token');
$th = Loader::helper('text');


?>

<div class="ccm-dashboard-content-full">

    <script type="text/javascript">
        $(function() {
            $('#level').removeClass('form-control').select2();
        });
    </script>

    <form role="form" action="<?php echo $controller->action('view')?>" class="form-inline ccm-search-fields">
        <div class="ccm-search-fields-row">
            <div class="form-group">
                <?php echo $form->label('keywords', t('Search'))?>
                <div class="ccm-search-field-content">
                    <div class="ccm-search-main-lookup-field">
                        <i class="fa fa-search"></i>
                        <?php echo $form->search('keywords', array('placeholder' => t('Keywords')))?>
                        <button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?php echo t('Search')?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ccm-search-fields-row">
            <div class="form-group">
                <?php echo $form->label('channel', t('Channel'))?>
                <div class="ccm-search-field-content">
                    <?php echo $form->select('channel', $channels)?>
                    <?php if ($selectedChannel) { ?>
                        <a href="<?php echo $controller->action('clear', $valt->generate(), $selectedChannel)?>" class="btn btn-default btn-sm"><?php echo tc('%s is a channel', 'Clear all in %s', Log::getChannelDisplayName($selectedChannel))?></a>
                    <?php } else { ?>
                        <a href="<?php echo $controller->action('clear', $valt->generate())?>" class="btn btn-default btn-sm"><?php echo t('Clear all')?></a>
                     <?php } ?>
                </div>
            </div>
        </div>

        <div class="ccm-search-fields-row">
            <div class="form-group">
                <?php echo $form->label('level', t('Level'))?>
                <div class="ccm-search-field-content">
                    <?php echo $form->selectMultiple('level', $levels, array_keys($levels), array('style' => 'width: 360px'))?>
                </div>
            </div>
        </div>

        <div class="ccm-search-fields-submit">
            <button type="submit" class="btn btn-primary pull-right"><?php echo t('Search')?></button>
        </div>

    </form>

    <div class="table-responsive">
        <table class="ccm-search-results-table">
            <thead>
                <tr>
                    <th class="<?php echo $list->getSearchResultsClass('logID')?>"><a href="<?php echo $list->getSortByURL('logID', 'desc')?>"><?php echo t('Date/Time')?></a></th>
                    <th class="<?php echo $list->getSearchResultsClass('level')?>"><a href="<?php echo $list->getSortByURL('level', 'desc')?>"><?php echo t('Level')?></a></th>
                    <th><span><?php echo t('Channel')?></span></th>
                    <th><span><?php echo t('User')?></span></th>
                    <th><span><?php echo t('Message')?></span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($entries as $ent) { ?>
                <tr>
                    <td valign="top" style="white-space: nowrap" class="active"><?php
                        print $ent->getDisplayTimestamp();
                    ?></td>
                    <td valign="top" style="text-align: center"><?php echo $ent->getLevelIcon()?></td>
                    <td valign="top" style="white-space: nowrap"><?php echo $ent->getChannelDisplayName()?></td>
                    <td valign="top"><strong><?php
                    $uID = $ent->getUserID();
                    if(empty($uID)) {
                        echo t("Guest");
                    } else {
                        $u = User::getByUserID($uID);
                        if(is_object($u)) {
                            echo $u->getUserName();
                        }
                        else {
                            echo tc('Deleted user', 'Deleted (id: %s)', $uID);
                        }
                    }
                    ?></strong></td>
                    <td style="width: 100%"><?php echo $th->makenice($ent->getMessage())?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- END Body Pane -->
    <?php echo $list->displayPagingV2()?>

</div>
