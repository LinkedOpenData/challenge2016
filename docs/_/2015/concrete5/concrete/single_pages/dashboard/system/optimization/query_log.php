<?php
defined('C5_EXECUTE') or die("Access Denied.");
$valt = Loader::helper('validation/token');
$th = Loader::helper('text');
?>

<?php if ($controller->getTask() == 'inspect') { ?>

    <div class="ccm-ui">
    <div class="alert alert-info"><?php echo $query?></div>
    <table class="table">
    <?php foreach($parameters as $params) { ?>
        <tr>
            <td><?php echo $params?></td>
        </tr>
    <?php } ?>
    </table>
    </div>

<?php } else { ?>

    <?php if (count($entries)) { ?>

        <p class="lead"><?php echo t('Total Logged: %s', $total)?></p>

    <div class="ccm-dashboard-content-full">

        <div data-search-element="results">
            <div class="table-responsive">
                <table class="ccm-search-results-table">
                    <thead>
                        <tr>
                            <th class="<?php echo $list->getSortClassName('queryTotal')?>" style="white-space: nowrap"><a href="<?php echo $list->getSortURL('queryTotal', 'desc')?>"><?php echo t('Times Run')?></a></th>
                            <th class="<?php echo $list->getSortClassName('query')?>"><a href="<?php echo $list->getSortURL('query', 'asc')?>"><?php echo t('Query')?></a></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($entries as $ent) { ?>
                        <tr>
                            <td valign="top"><?php echo $ent['queryTotal']?></td>
                            <td valign="top"><?php echo $ent['query']?></td>
                            <td><a href="<?php echo $view->action('inspect', rawurlencode($ent['query']))?>" dialog-width="600" dialog-title="<?php echo t('Query Details')?>" dialog-modal="true" dialog-height="400" class="dialog-launch icon-link"><i class="fa fa-search"></i></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ccm-search-results-pagination">
            <?php print $pagination->renderView('dashboard');?>
        </div>

    </div>

    <div class="ccm-dashboard-header-buttons">
        <form method="post" action="<?php echo $view->action('clear')?>">
            <?php echo Loader::helper('validation/token')->output('clear')?>
            <button type="submit" class="btn btn-danger"><?php echo t('Clear Log')?></button>
        </form>
    </div>

    <?php } else { ?>

    <p><?php echo t("The database query log is empty.")?></p>

    <?php } ?>


<?php } ?>