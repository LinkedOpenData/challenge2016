<?php
defined('C5_EXECUTE') or die("Access Denied.");
$section = 'groups';

$txt = Loader::helper('text');
$ih = Loader::helper('concrete/ui');
$valt = Loader::helper('validation/token');

$date = Loader::helper('form/date_time');
$form = Loader::helper('form');

$rootNode = $tree->getRootTreeNodeObject();

$guestGroupNode = GroupTreeNode::getTreeNodeByGroupID(GUEST_GROUP_ID);
$registeredGroupNode = GroupTreeNode::getTreeNodeByGroupID(REGISTERED_GROUP_ID);

?>

<form class="form-stacked" method="post" id="add-group-form" action="<?php echo $view->url('/dashboard/users/add_group/', 'do_add')?>">
<?php echo $valt->output('add_or_update_group')?>
<fieldset>
	<legend><?php echo t('Group Details')?></legend>
<div class="form-group">
<?php echo $form->label('gName', t('Name'))?>
	<input type="text" class="form-control" name="gName" value="<?php echo Core::make('helper/text')->entities($_POST['gName'])?>" />
</div>

<div class="form-group">
<?php echo $form->label('gDescription', t('Description'))?>
<div class="controls">
	<?php echo $form->textarea('gDescription', array('rows' => 6, 'class' =>'span6'))?>
</div>
</div>

<div class="form-group">
<label class="control-label"><?php echo t('Parent Group')?></label>
<div class="controls">
    <div class="groups-tree" style="width: 460px" data-groups-tree="<?php echo $tree->getTreeID()?>">
    </div>
    <?php echo $form->hidden('gParentNodeID')?>

    <script type="text/javascript">
    $(function() {
       $('[data-groups-tree=<?php echo $tree->getTreeID()?>]').concreteGroupsTree({
          'treeID': '<?php echo $tree->getTreeID()?>',
          'chooseNodeInForm': 'single',
		  'enableDragAndDrop': false,
          <?php if ($this->controller->isPost()) { ?>
             'selectNodesByKey': [<?php echo intval($_POST['gParentNodeID'])?>]
          <?php } else {
          	if (is_object($rootNode)) { ?>
          		'selectNodesByKey': [<?php echo intval($rootNode->getTreeNodeID())?>],
          		<?php } ?>
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
</div>
</div>

</fieldset>
<?php if (Config::get('concrete.user.profiles_enabled')) { ?>
<fieldset>
	<div class="form-group">
        <div class="checkbox">
            <label>
            <?php echo $form->checkbox('gIsBadge', 1, false)?>
            <span><?php echo t('This group is a badge.')?> <i class="fa fa-question-circle launch-tooltip" title="<?php echo t('Badges are publicly viewable in user profiles, and display pictures and a custom description. Badges can be automatically assigned or given out by administrators.')?>"></i> </span>
            </label>
        </div>
	</div>

    <div id="gUserBadgeOptions" style="display: none">
        <div class="form-group">
            <label class="control-label"><?php echo t('Image')?></label>
            <div class="controls">
                <?php

                $af = Loader::helper('concrete/asset_library');
                print $af->image('gBadgeFID', 'gBadgeFID', t('Choose Badge Image'), $badgeImage);
                ?>

            </div>
        </div>

        <div class="form-group">
            <?php echo $form->label('gBadgeDescription', t('Badge Description'))?>
            <div class="controls">
                <?php echo $form->textarea('gBadgeDescription', array('rows' => 6, 'class' =>'span6'))?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->label('gBadgeCommunityPointValue', t('Community Points'))?>
            <div class="controls">
                <?php echo $form->text('gBadgeCommunityPointValue', Config::get('concrete.user.group.badge.default_point_value'), array('class' => 'span1'))?>
            </div>
        </div>

    </div>

</fieldset>
<?php } ?>

<fieldset>
	<legend><?php echo t('Automation')?></legend>
	<div class="form-group">
        <div class="checkbox">
            <label>
            <?php echo $form->checkbox('gIsAutomated', 1, false)?>
            <span><?php echo t('This group is automatically entered.')?> <i class="fa fa-question-circle launch-tooltip" title="<?php echo t("Automated Groups aren't assigned by administrators. They are checked against code at certain times that determines whether users should enter them.")?>"></i> </span>
            </label>
        </div>
	</div>

<div id="gAutomationOptions" style="display: none">
	<div class="form-group">
        <label><?php echo t('Check Group')?></label>
        <div class="checkbox">
            <label>
                <?php echo $form->checkbox('gCheckAutomationOnRegister', 1)?>
                <span><?php echo t('When a user registers.')?></span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <?php echo $form->checkbox('gCheckAutomationOnLogin', 1)?>
                <span><?php echo t('When a user signs in.')?></span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <?php echo $form->checkbox('gCheckAutomationOnJobRun', 1)?>
                <span><?php echo t('When the "Check Automated Groups" Job runs.')?></span>
            </label>
        </div>
        <div class="alert alert-info">
            <?php
            print t('For custom automated group actions, make sure an automation group controller exists.');
            ?>
        </div>
	</div>
</div>


<div class="form-group">
	<div class="checkbox">
        <label>
            <?php echo $form->checkbox('gUserExpirationIsEnabled', 1, false)?>
            <?php echo t('Automatically remove users from this group.')?>
        </label>
	</div>

	<div class="controls" style="">
	<?php echo $form->select("gUserExpirationMethod", array(
		'SET_TIME' => t('at a specific date and time'),
			'INTERVAL' => t('once a certain amount of time has passed')

	), array('disabled' => true, 'class'=>'form-control'));?>
	</div>
</div>

<div id="gUserExpirationSetTimeOptions" style="display: none">
<div class="form-group">
<label for="gUserExpirationSetDateTime"><?php echo t('Expiration Date')?></label>
<?php echo $date->datetime('gUserExpirationSetDateTime')?>
</div>
</div>
<div id="gUserExpirationIntervalOptions" style="display: none">
<div class="form-group">
<label><?php echo t('Accounts expire after')?></label>
<div class="controls">
<table class="table " style="width: auto">
<tr>
	<th><?php echo t('Days')?></th>
	<th><?php echo t('Hours')?></th>
	<th><?php echo t('Minutes')?></th>
</tr>
<tr>
<td>
<?php echo $form->text('gUserExpirationIntervalDays', array('style' => $style, 'class' => 'span1'))?>
</td>
<td>
<?php echo $form->text('gUserExpirationIntervalHours', array('style' => $style, 'class' => 'span1'))?>
</td>
<td>
<?php echo $form->text('gUserExpirationIntervalMinutes', array('style' => $style, 'class' => 'span1'))?>
</td>
</tr>
</table>
</div>
</div>
</div>

<div id="gUserExpirationAction" style="display: none">
<div class="form-group">
<?php echo $form->label('gUserExpirationAction', t('Expiration Action'))?>
<div class="controls">
<?php echo $form->select("gUserExpirationAction", array(
'REMOVE' => t('Remove the user from this group'),
	'DEACTIVATE' => t('Deactivate the user account'),
	'REMOVE_DEACTIVATE' => t('Remove the user from the group and deactivate the account')

));?>
</div>
</div>
</div>
</fieldset>


<div class="ccm-dashboard-form-actions-wrapper">
<div class="ccm-dashboard-form-actions">
	<a href="<?php echo View::url('/dashboard/users/groups')?>" class="btn btn-default pull-left"><?php echo t('Cancel')?></a>
	<?php echo Loader::helper("form")->submit('add', t('Add Group'), array('class' => 'btn btn-primary pull-right'))?>
</div>
</div>


</form>

<script type="text/javascript">
ccm_checkGroupExpirationOptions = function() {
	var sel = $("select[name=gUserExpirationMethod]");
	var cb = $("input[name=gUserExpirationIsEnabled]");
	if (cb.prop('checked')) {
		sel.attr('disabled', false);
		switch(sel.val()) {
			case 'SET_TIME':
				$("#gUserExpirationSetTimeOptions").show();
				$("#gUserExpirationIntervalOptions").hide();
				break;
			case 'INTERVAL':
				$("#gUserExpirationSetTimeOptions").hide();
				$("#gUserExpirationIntervalOptions").show();
				break;
		}
		$("#gUserExpirationAction").show();
	} else {
		sel.attr('disabled', true);
		$("#gUserExpirationSetTimeOptions").hide();
		$("#gUserExpirationIntervalOptions").hide();
		$("#gUserExpirationAction").hide();
	}
}

$(function() {
	$("input[name=gUserExpirationIsEnabled]").click(ccm_checkGroupExpirationOptions);
	$("select[name=gUserExpirationMethod]").change(ccm_checkGroupExpirationOptions);
	$('input[name=gIsBadge]').on('click', function() {
		if ($(this).is(':checked')) {
			$('#gUserBadgeOptions').show();
		} else {
			$('#gUserBadgeOptions').hide();
		}
	}).triggerHandler('click');
	$('input[name=gIsAutomated]').on('click', function() {
		if ($(this).is(':checked')) {
			$('#gAutomationOptions').show();
		} else {
			$('#gAutomationOptions').hide();
		}
	}).triggerHandler('click');
	$('.icon-question-sign').tooltip();
	ccm_checkGroupExpirationOptions();
});
</script>
