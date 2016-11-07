<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */

?>
<form class="form-inline" action="<?php echo $view->action('view')?>" method="get">
    <div class="ccm-dashboard-header-buttons">
	    <a href="<?php echo View::url('/dashboard/users/points/assign')?>" class="btn btn-primary"><?php echo t('Add Points')?></a>
	</div>
	
    <div class="ccm-pane-options">
        <div class="ccm-pane-options-permanent-search">
            <?php echo $form->label('uName', t('User'))?>
            <?php echo $form_user_selector->quickSelect('uName',$_GET['uName'],array('form-control'));?>
            <input type="submit" value="<?php echo t('Search')?>" class="btn" />


        </div>
    </div>
</form>
<br />
<?php
if (!$mode) {
	$mode = $_REQUEST['mode'];
}
$txt = Loader::helper('text');
$keywords = $_REQUEST['keywords'];

if (count($entries) > 0) { ?>	
	<table border="0" cellspacing="0" cellpadding="0" id="ccm-product-list" class="table table-striped">
	<tr>
		<th class="<?php echo $upEntryList->getSearchResultsClass('uName')?>"><a href="<?php echo $upEntryList->getSortByURL('uName', 'asc')?>"><?php echo t('User')?></a></th>
		<th class="<?php echo $upEntryList->getSearchResultsClass('upaName')?>"><a href="<?php echo $upEntryList->getSortByURL('upaName', 'asc')?>"><?php echo t('Action')?></a></th>
		<th class="<?php echo $upEntryList->getSearchResultsClass('upPoints')?>"><a href="<?php echo $upEntryList->getSortByURL('upPoints', 'asc')?>"><?php echo t('Points')?></a></th>
		<th class="<?php echo $upEntryList->getSearchResultsClass('timestamp')?>"><a href="<?php echo $upEntryList->getSortByURL('timestamp', 'asc')?>"><?php echo t('Date Assigned')?></a></th>
		<th><?php echo t("Details")?></th>
		<th></th>
	</tr>
    <?php 
    foreach($entries as $up) { ?>
    	<tr>
    		<?php
        		$ui = $up->getUserPointEntryUserObject();
        		$action = $up->getUserPointEntryActionObject();
    		?>
    		<td><?php if (is_object($ui)) { ?><?php echo h($ui->getUserName())?><?php } ?></td>
    		<td><?php if (is_object($action)) { ?><?php echo h($action->getUserPointActionName())?><?php } ?></td>
    		<td><?php echo number_format($up->getUserPointEntryValue())?></td>
    		<td><?php echo $dh->formatDateTime($up->getUserPointEntryTimestamp());?></td>
    		<td><?php echo h($up->getUserPointEntryDescription())?></td>
    		<td style="Text-align: right">
                <?php
                $delete = \Concrete\Core\Url\Url::createFromUrl($view->action('deleteEntry', $up->getUserPointEntryID()));

                $delete->setQuery(array(
                    'ccm_token' => \Core::make('helper/validation/token')->generate('delete_community_points')
                ));
                ?>
    		    <a href="<?php echo $delete?>" class="btn btn-sm btn-danger"><?php echo t('Delete')?></a>
    		</td>
    	</tr>
    <?php } ?>
</table>
<?php } else { ?>
	<div id="ccm-list-none"><?php echo t('No entries found.')?></div>
<?php } 
$upEntryList->displayPaging(); ?>