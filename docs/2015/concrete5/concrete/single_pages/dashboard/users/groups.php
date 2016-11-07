<?php
defined('C5_EXECUTE') or die("Access Denied.");

$valt = Loader::helper('validation/token');
$ih = Loader::helper('concrete/ui');
$form = Loader::helper('form');
$date = Loader::helper('form/date_time');

if (isset($group)) { ?>

<form method="post" id="update-group-form" class="form-stacked" action="<?php echo $view->url('/dashboard/users/groups/', 'update_group')?>" role="form">
    <?php echo $valt->output('add_or_update_group')?>
	<?php
	    $u = new User();

	$delConfirmJS = t('Are you sure you want to permanently remove this group?');
	if($u->isSuperUser() == false){ ?>
		<?php echo t('You must be logged in as %s to remove groups.', USER_SUPER)?>
	<?php }else{ ?>

	<script type="text/javascript">
	deleteGroup = function() {
		if (confirm('<?php echo $delConfirmJS?>')) {
			location.href = "<?php echo $view->url('/dashboard/users/groups', 'delete', $group->getGroupID(), $valt->generate('delete_group_' . $group->getGroupID() ))?>";
		}
	}
	</script>

	<?php } ?>

    <fieldset>
	    <legend><?php echo t('Group Details')?></legend>
	    <div class="form-group">
	        <label for="gName"><?php echo t('Name')?></label>
	        <input type="text" name="gName" id="gName" class="form-control" value="<?php echo Loader::helper('text')->entities($group->getGroupName())?>" />
	    </div>

	    <div class="form-group">
	        <label for="gDescription"><?php echo t('Description')?></label>
	        <textarea name="gDescription" id="gDescription" rows="6" class="form-control"><?php echo Loader::helper("text")->entities($group->getGroupDescription())?></textarea>
	    </div>
    </fieldset>

	<?php if (Config::get('concrete.user.profiles_enabled')) { ?>

	<fieldset>
        <div class="form-group">
            <div class="checkbox">
                <label>
                <?php echo $form->checkbox('gIsBadge', 1, $group->isGroupBadge())?>
                <span><?php echo t('This group is a badge.')?> <i class="fa fa-question-circle launch-tooltip" title="<?php echo t('Badges are publicly viewable in user profiles, and display pictures and a custom description. Badges can be automatically assigned or given out by administrators.')?>"></i> </span>
                </label>
            </div>
        </div>

        <div id="gUserBadgeOptions" style="display: none">
		    <div class="form-group">
			    <label for="gBadgeFID"><?php echo t('Image')?></label>

                    <?php
                        $af = Loader::helper('concrete/asset_library');
        				print $af->image('gBadgeFID', 'gBadgeFID', t('Choose Badge Image'), $group->getGroupBadgeImageObject());
                    ?>

            </div>

            <div class="form-group">
                <label for="gBadgeDescription"><?php echo t('Badge Description')?></label>
                <?php echo $form->textarea('gBadgeDescription', $group->getGroupBadgeDescription(), array('rows' => 6, 'class' =>'form-control'))?>
            </div>

            <div class="form-group">
                <label for="gBadgeCommunityPointValue"><?php echo t('Community Points')?></label>
                <?php echo $form->text('gBadgeCommunityPointValue', $group->getGroupBadgeCommunityPointValue(), array('class' => 'form-control'))?>
            </div>
		</div>
	</fieldset>
	<?php } ?>

	<fieldset>
		<legend><?php echo t('Automation')?></legend>
		<div class="form-group">
            <div class="checkbox">
                <label>
                <?php echo $form->checkbox('gIsAutomated', 1, $group->isGroupAutomated())?>
                <span><?php echo t('This group is automatically entered.')?> <i class="fa fa-question-circle launch-tooltip" title="<?php echo t("Automated Groups aren't assigned by administrators. They are checked against code at certain times that determines whether users should enter them.")?>"></i> </span>
                </label>
            </div>

		</div>

    	<div id="gAutomationOptions" style="display: none">
    		<div class="form-group">
    		    <label><?php echo t('Check Group')?></label>

    		    <div class="checkbox">
                    <label>
    				<?php echo $form->checkbox('gCheckAutomationOnRegister', 1, $group->checkGroupAutomationOnRegister())?>
    				<span><?php echo t('When a user registers.')?></span>
                    </label>
    			</div>

    			<div class="checkbox">
                    <label>
    				<?php echo $form->checkbox('gCheckAutomationOnLogin', 1, $group->checkGroupAutomationOnLogin())?>
    				<span><?php echo t('When a user signs in.')?></span>
                    </label>
    			</div>

    			<div class="checkbox">
                    <label>
    				<?php echo $form->checkbox('gCheckAutomationOnJobRun', 1, $group->checkGroupAutomationOnJobRun())?>
    				<span><?php echo t('When the "Check Automated Groups" Job runs.')?></span>
                    </label>
    			</div>
    		</div>

    		<div class="alert alert-info">
    			<?php
    			$path = $group->getGroupAutomationControllerClass();
    			print t('For custom automated group actions, make sure an automation group controller exists at %s', $path);
    			?>
    		</div>
    	</div>

    	<div class="form-group">
            <div class="checkbox">
                <label>
    		<?php echo $form->checkbox('gUserExpirationIsEnabled', 1, $group->isGroupExpirationEnabled())?>
    		<span><?php echo t('Automatically remove users from this group')?></span></label></div>
    	</div>

    	<div class="form-group">
    		<?php echo $form->select("gUserExpirationMethod", array(
    		    'SET_TIME' => t('at a specific date and time'),
    			'INTERVAL' => t('once a certain amount of time has passed')
            ), $group->getGroupExpirationMethod(), array('disabled' => true, 'class' => 'form-control'));?>
    	</div>

    	<div id="gUserExpirationSetTimeOptions" style="display: none">
    	    <div class="form-group">
    	        <label for="gUserExpirationSetDateTime"><?php echo t('Expiration Date')?></label>
                <?php echo $date->datetime('gUserExpirationSetDateTime', $group->getGroupExpirationDateTime())?>
            </div>
    	</div>

    	<div id="gUserExpirationIntervalOptions" style="display: none">
    	    <div class="form-group">
                <label for=""><?php echo t('Accounts expire after')?></label>
                <div>
                	<table class="table" style="width: auto">
                    	<tr>
                    		<th><?php echo t('Days')?></th>
                    		<th><?php echo t('Hours')?></th>
                    		<th><?php echo t('Minutes')?></th>
                    	</tr>

                        <tr>
                            <?php
                            	$days = $group->getGroupExpirationIntervalDays();
                            	$hours = $group->getGroupExpirationIntervalHours();
                            	$minutes = $group->getGroupExpirationIntervalMinutes();
                            	$style = 'width: 60px';
                        	?>

                        	<td valign="top">
                        	    <?php echo $form->text('gUserExpirationIntervalDays', $days, array('style' => $style))?>
                        	</td>
                        	<td valign="top">
                        	    <?php echo $form->text('gUserExpirationIntervalHours', $hours, array('style' => $style))?>
                        	</td>
                        	<td valign="top">
                        	    <?php echo $form->text('gUserExpirationIntervalMinutes', $minutes, array('style' => $style))?>
                        	</td>
                        </tr>
                    </table>
                </div>
            </div>
    	</div>

    	<div id="gUserExpirationAction" style="display: none">
    	    <div class="form-group">
    	        <label for="gUserExpirationAction"><?php echo t('Expiration Action')?></label>
                <?php echo $form->select("gUserExpirationAction", array(
                        'REMOVE' => t('Remove the user from this group'),
                        'DEACTIVATE' => t('Deactivate the user account'),
                        'REMOVE_DEACTIVATE' => t('Remove the user from the group and deactivate the account')
                ), $group->getGroupExpirationAction(),
                array('class' => 'form-control'));?>
            </div>
    	</div>

        <input type="hidden" name="gID" value="<?php echo $group->getGroupID()?>" />
	</fieldset>

	<div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?php echo $view->url('/dashboard/users/groups')?>" class="btn btn-default pull-left"><?php echo t('Cancel')?></a>
            <button class="btn pull-right btn-primary" style="margin-left: 10px" type="submit"><?php echo t('Update Group')?></button>

            <?php if ($u->isSuperUser()) { ?>
                <?php print $ih->button_js(t('Delete'), "deleteGroup()", 'right', 'btn-danger');?>
            <?php } ?>
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
	ccm_checkGroupExpirationOptions();
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

});
</script>
<?php } else { ?>

	<?php if ($canAddGroup) { ?>
	<div class="ccm-dashboard-header-buttons">
		<a href="<?php echo View::url('/dashboard/users/add_group')?>" class="btn btn-primary"><?php echo t("Add Group")?></a>
	</div>
	<?php } ?>


<?php Loader::element('group/search', array('controller' => $searchController, 'selectMode' => false))?>


<?php } ?>
