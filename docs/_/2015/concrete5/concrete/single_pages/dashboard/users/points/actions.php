<?php defined('C5_EXECUTE') or die("Access Denied.");

    //$interface = Loader::helper('interface');
?>

<?php if($showForm) { ?>
<form method="post" action="<?php echo $view->action('save')?>" id="ccm-community-points-action">
    <div class="row">
        <div class="col-md-12">
    
            <?php 
        		echo $form->hidden('upaID',$upaID);
        	?>               
        	
        	<div class="checkbox">
                <label>
                    <?php echo $form->checkbox('upaIsActive', 1, ($upaIsActive == 1 || (!$upaID)))?> <?php echo t('Enabled')?>
                </label>
            </div>
	
        	<div class="form-group">
        	    <?php echo $form->label('upaHandle', t('Action Handle'));?>
        		<div class="input">
            		<?php 
                		$args = array();
                		if ($upaHasCustomClass) { 
                			$args['disabled'] = 'disabled';
                		}
            		?>
                    <?php echo $form->text('upaHandle',$upaHandle, $args);?>
        		</div>
        	</div>
	
        	<div class="form-group">
        	    <?php echo $form->label('upaName', t('Action Name'));?>
        		<div class="input">
        		    <?php echo $form->text('upaName',$upaName);?>
        		</div>
        	</div>
	
        	<div class="form-group">
                <?php echo $form->label('upaDefaultPoints', t('Default Points'));?>
        		<div class="input">
        		    <?php echo $form->text('upaDefaultPoints',$upaDefaultPoints);?>
        		</div>
        	</div>
	
        	<div class="form-group">
        	    <?php echo $form->label('gBadgeID', t('Badge Associated'));?>
        		<div class="input">
        			<?php echo $form->select('gBadgeID', $badges, $gBadgeID)?>
        			<i class="icon-question-sign launch-tooltip" title="<?php echo t('If a badge is assigned to this action, the first time this user performs this action they will be granted the badge.')?>"></i>
        		</div>
        	</div>

            <?php 
            $label = t('Add Action');
            if ($upaID > 0) {
            	$label = t('Update Action');
            }
            ?>
    
            <div class="ccm-dashboard-form-actions-wrapper">
                <div class="ccm-dashboard-form-actions">
                    <a href="<?php echo $view->url('/dashboard/users/points/actions')?>" class="btn btn-default pull-left"><?php echo t('Back to List')?></a>
                    <button class="btn btn-primary pull-right" type="submit"><?php echo $label?></button>
                </div>
            </div>
        </div>
    </div>
</form>		
<?php } else { ?>	
	<div class="ccm-dashboard-header-buttons">
	    <a href="<?php echo $view->action('add')?>" class="btn btn-primary"><?php echo t('Add Action')?></a>
	</div>
	
	<?php
		if (!$mode) {
			$mode = $_REQUEST['mode'];
		}
		$txt = Loader::helper('text');
		$keywords = $_REQUEST['keywords'];
		
		if (count($actions) > 0) { ?>	
			<table border="0" cellspacing="0" cellpadding="0" class="table table-striped">
    			<tr>
    				<th><?php echo t("Active")?></th>
    				<th class="<?php echo $actionList->getSearchResultsClass('upaName')?>"><a href="<?php echo $actionList->getSortByURL('upaName', 'asc')?>"><?php echo t('Action Name')?></a></th>
    				<th class="<?php echo $actionList->getSearchResultsClass('upaHandle')?>"><a href="<?php echo $actionList->getSortByURL('upaHandle', 'asc')?>"><?php echo t('Action Handle')?></a></th>
    				<th class="<?php echo $actionList->getSearchResultsClass('upaDefaultPoints')?>"><a href="<?php echo $actionList->getSortByURL('upaDefaultPoints', 'asc')?>"><?php echo t('Default Points')?></a></th>
    				<th class="<?php echo $actionList->getSearchResultsClass('upaBadgeGroupID')?>"><a href="<?php echo $actionList->getSortByURL('upaBadgeGroupID', 'asc')?>"><?php echo t('Group')?></a></th>
    				<th></th>
    			</tr>
    			
        		<?php 
        		foreach($actions as $upa) { 
                ?>
        		<tr class="">
        			<td style="text-align: center"><?php if ($upa['upaIsActive']) { ?><i class="fa fa-check"></i><?php } ?></td>
        			<td><?php echo $upa['upaName']?></td>
        			<td><?php echo $upa['upaHandle']?></td>
        			<td><?php echo number_format($upa['upaDefaultPoints'])?></td>
        			<td><?php echo $upa['gName'];?></td>
        			<td style="text-align: right">
        			    <a href="<?php echo $view->action($upa['upaID'])?>" class="btn btn-sm btn-default"><?php echo t('Edit')?></a>
        			    <a href="<?php echo $view->action('delete',$upa['upaID'])?>" class="btn btn-sm btn-danger"><?php echo t('Delete')?></a>
        			</td>
        		</tr>
        		<?php } ?>
		</table>
		<?php } else { ?>
			<p><?php echo t('No Actions found.')?></p>
		<?php } ?>
	
<div class="ccm-pane-footer">
<?php echo $actionList->displayPagingV2(); ?>
</div>

<?php } ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>