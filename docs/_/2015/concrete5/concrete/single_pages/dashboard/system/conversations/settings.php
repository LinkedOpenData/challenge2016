<?php  defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
$file = Loader::helper('file');
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Conversations Settings'), false, 'span8 offset2', false);
?>
<form action="<?php echo $view->action('save')?>" method='post'>
		<fieldset>
			<legend><?php echo t('Attachment Settings'); ?></legend>
			<p style="margin-bottom: 25px; color: #aaa; display: block;" class="small"><?php echo t('Note: These settings can be overridden in the block edit form for individual conversations.') ?></p>
            <div class="form-group">
                <label class="control-label"><?php echo t('Enable Attachments')?></label>
                <?php echo $form->checkbox('attachmentsEnabled', 1, $attachmentsEnabled)?>
            </div>
			<div class="form-group">
				<label class="control-label"><?php echo t('Max Attachment Size for Guest Users. (MB)')?></label>
				<?php echo $form->text('maxFileSizeGuest', $maxFileSizeGuest > 0 ? $maxFileSizeGuest : '')?>
			</div>
            <div class="form-group">
				<label class="control-label"><?php echo t('Max Attachment Size for Registered Users. (MB)')?></label>
				<?php echo $form->text('maxFileSizeRegistered', $maxFileSizeRegistered > 0 ? $maxFileSizeRegistered : '')?>
			</div>
            <div class="form-group">
				<label class="control-label"><?php echo t('Max Attachments Per Message for Guest Users.')?></label>
				<?php echo $form->text('maxFilesGuest', $maxFilesGuest > 0 ? $maxFilesGuest : '')?>
			</div>
            <div class="form-group">
				<label class="control-label"><?php echo t('Max Attachments Per Message for Registered Users')?></label>
				<?php echo $form->text('maxFilesRegistered', $maxFilesRegistered > 0 ?  $maxFilesRegistered : '')?>
			</div>
            <div class="form-group">
				<label class="control-label"><?php echo t('Allowed File Extensions (Comma separated, no periods).')?></label>
    			<?php echo $form->textarea('fileExtensions', $fileExtensions)?>
			</div>
		</fieldset>
    <fieldset>
        <legend><?php echo t('Editor')?></legend>
        <div class="form-group">
            <?php echo $form->label('activeEditor', t('Active Conversation Editor'))?>
            <?php echo Loader::helper('form')->select('activeEditor', $editors, $active);?>
        </div>
    </fieldset>
	<fieldset>
		<legend><?php echo t('Notification')?></legend>
		<div class="form-group">
			<label class="control-label"><?php echo t('Users To Receive Conversation Notifications')?></label>
			<?php echo Core::make("helper/form/user_selector")->selectMultipleUsers('defaultUsers', $notificationUsers)?>
		</div>
		<div class="form-group">
			<label class="control-label"><?php echo t('Subscribe Option')?></label>
			<div class="checkbox">
				<label><?php echo $form->checkbox('subscriptionEnabled', 1, $subscriptionEnabled)?>
					<?php echo t('Yes, allow registered users to choose to subscribe to conversations.')?>
				</label>
			</div>
		</div>
	</fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
		    <button class='btn btn-primary pull-right'><?php echo t('Save'); ?></button>
	    </div>
    </div>
</form>