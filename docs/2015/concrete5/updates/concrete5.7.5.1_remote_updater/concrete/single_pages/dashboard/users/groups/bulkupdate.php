<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');?>

<?php if (is_array($selectedGroups)) { ?>

<h4><?php echo t('Confirm')?></h4>
<?php if ($gParent instanceof Group) { ?>
<p><?php echo t('Move the following group(s) beneath <strong>%s</strong>.', $gParent->getGroupDisplayName())?></p>
<?php } else { ?> 
<p><?php echo t('Move the following group(s) <strong>to the top level of groups</strong>.')?></p>
<?php } ?>

<ul>
<?php foreach($selectedGroups as $g) { ?>
	<li><?php echo $g->getGroupDisplayName()?></li>
<?php } ?>
</ul>

<form method="post" action="<?php echo $view->action('confirm')?>" role="form">
    <input type="hidden" name="gParentNodeID" value="<?php echo h($_REQUEST['gParentNodeID'])?>" />
    
	<?php foreach($_REQUEST['gID'] as $gID) { ?>
		<input type="hidden" name="gID[]" value="<?php echo h($gID)?>" />
	<?php } ?>
	<br/>
	<input type="hidden" name="gName" value="<?php echo h($_REQUEST['gName'])?>" />
	
	<div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?php echo $interface->submit(t('Move Groups'), '', 'right', 'btn-primary'); ?>
        </div>
    </div>
</form>

<?php } else if (is_array($groups)) { ?>

<form action="<?php echo $view->action('move')?>" method="post" data-form="move-groups">

    <div class="row">
        <div class="col-md-6">
            <h4><?php echo t('Choose Groups to Move')?></h4>

            <div class="checkbox">
                <label style="user-select: none; -moz-user-select: none; -webkit-user-select: none">
                    <input data-toggle="checkbox" type="checkbox" /> <strong><?php echo t('Select All')?></strong>
                </label>
            </div>
            <?php foreach($groups as $g) { ?>
                <div class="checkbox" data-checkbox="group-list"><label>
                    <input name="gID[]" type="checkbox" <?php if (is_array($_POST['gID']) && in_array($g->getGroupID(), $_POST['gID'])) { ?>checked<?php } ?> value="<?php echo $g->getGroupID()?>" /> <?php echo $g->getGroupDisplayName()?>
                </label></div>
            <?php } ?>
        </div>
        
        <div class="col-md-6">
            <h4><?php echo t('Choose New Parent Location')?></h4>
            
            <?php echo $form->hidden('gParentNodeID')?>
            
            <div class="nested-groups-tree" data-groups-tree="<?php echo $tree->getTreeID()?>">
            
            </div>
            
            <?php
            $guestGroupNode = GroupTreeNode::getTreeNodeByGroupID(GUEST_GROUP_ID);
            $registeredGroupNode = GroupTreeNode::getTreeNodeByGroupID(REGISTERED_GROUP_ID);
            ?>
        </div>
    </div>
    
    <hr/>
    
    <div class="row">
        
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3><?php echo t('Move')?></h3>
            <p><?php echo t('Move selected groups (left column) beneath selected group (right column)')?></p>
            
            <div class="ccm-dashboard-form-actions-wrapper">
                <div class="ccm-dashboard-form-actions">
                    <?php echo $interface->submit(t('Move'), '', 'right', 'btn-primary'); ?>
                </div>
            </div>
        </div>
    </div>

	<input type="hidden" name="gName" value="<?php echo h($_REQUEST['gName'])?>" />
</form>

<script type="text/javascript">
$(function() {
	$('input[data-toggle=checkbox]').on('click', function() {
		if ($(this).is(':checked')) {
			$('div[data-checkbox=group-list] input[type=checkbox]').prop('checked', true);
		} else {
			$('div[data-checkbox=group-list]  input[type=checkbox]').prop('checked', false);

		}
	});
})
</script>

<script type="text/javascript">
    $(function() {
       $('[data-groups-tree=<?php echo $tree->getTreeID()?>]').concreteGroupsTree({
          'treeID': '<?php echo $tree->getTreeID()?>',
          'chooseNodeInForm': 'single',
		  'enableDragAndDrop': false,
          <?php if ($this->controller->isPost()) { ?>
             'selectNodesByKey': [<?php echo intval($_POST['gParentNodeID'])?>],
          <?php } ?>
          'removeNodesByID': ['<?php echo $guestGroupNode->getTreeNodeID()?>','<?php echo $registeredGroupNode->getTreeNodeID()?>'],
          'onSelect': function(select, node) {
             if (select) {
                $('input[name=gParentNodeID]').val(node.data.key);
             } else {
                $('input[name=gParentNodeID]').val('');
             }
          }
       });
    });
    </script>

<?php } else { ?>

<form method="POST" action="<?php echo $view->action('search')?>">
	<h4><?php echo t('Search for Groups to Move')?></h4>
	
	<div class="row">
	    <div class="col-md-6">
	        <fieldset>
            	<div class="form-group">
                    <?php echo $form->text('gName')?>
            	</div>
            </fieldset>
            
        	<div class="ccm-dashboard-form-actions-wrapper">
                <div class="ccm-dashboard-form-actions">
                    <?php echo $interface->submit(t('Search'), '', 'right', 'btn-primary'); ?>
                </div>
            </div>
	    </div>
	</div>
</form>

<?php } ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>
