<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
if (!is_array($messages)) {
	$messages = array();
}
$u = new User();
$ui = UserInfo::getByID($u->getUserID());
$page = Page::getByID($cID);
$editor = \Concrete\Core\Conversation\Editor\Editor::getActive();
$editor->setConversationObject($args['conversation']);
$val = Loader::helper('validation/token');
$form = Loader::helper('form');
?>

<?php Loader::element('conversation/message/add_form', array(
	'blockAreaHandle' => $blockAreaHandle,
	'cID' => $cID,
	'bID' => $bID,
	'editor' => $editor,
	'addMessageLabel' => $addMessageLabel,
	'attachmentsEnabled' => $attachmentsEnabled,
	'displayForm' => $displayForm,
	'displayPostingForm' => $displayPostingForm,
	'position' => 'top',
	'enablePosting' => $enablePosting,
	'conversation' => $conversation
));?>


<div class="ccm-conversation-message-list ccm-conversation-messages-<?php echo $displayMode?>">

	<div class="ccm-conversation-delete-message" data-dialog-title="<?php echo t('Delete Message')?>" data-cancel-button-title="<?php echo t('Cancel')?>" data-confirm-button-title="<?php echo t('Delete Message')?>">
		<?php echo t('Remove this message? Replies to it will not be removed.')?>
	</div>
	<div class="ccm-conversation-delete-attachment" data-dialog-title="<?php echo t('Delete Attachment')?>" data-cancel-button-title="<?php echo t('Cancel')?>" data-confirm-button-title="<?php echo t('Delete Attachment')?>">
		<?php echo t('Remove this attachment?')?>
	</div>
	<div class="ccm-conversation-message-permalink" data-dialog-title="<?php echo t('Link')?>" data-cancel-button-title="<?php echo t('Close')?>">
	</div>

	<div class="ccm-conversation-messages-header">
		<?php if ($enableOrdering) { ?>
		<select class="form-control pull-right ccm-sort-conversations" data-sort="conversation-message-list">
			<option value="date_asc" <?php if ($orderBy == 'date_asc') { ?>selected="selected"<?php } ?>><?php echo t('Earliest First')?></option>
			<option value="date_desc" <?php if ($orderBy == 'date_desc') { ?>selected="selected"<?php } ?>><?php echo t('Most Recent First')?></option>
			<option value="rating" <?php if ($orderBy == 'rating') { ?>selected="selected"<?php } ?>><?php echo t('Highest Rated')?></option>
		</select>
		<?php } ?>

		<?php Loader::element('conversation/count_header', array('conversation' => $conversation))?>
	</div>


	<div class="ccm-conversation-no-messages well well-small" <?php if (count($messages) > 0) { ?>style="display: none" <?php } ?>><?php echo t('No messages in this conversation.')?></div>

	<div class="ccm-conversation-messages">

	<?php foreach($messages as $m) {
		Loader::element('conversation/message', array('cID' => $cID, 'message' => $m, 'bID' => $bID, 'page' => $page, 'blockAreaHandle' => $blockAreaHandle, 'enablePosting' => $enablePosting, 'displayMode' => $displayMode, 'enableCommentRating' => $enableCommentRating, 'dateFormat' => $dateFormat, 'customDateFormat' => $customDateFormat));
	} ?>

	</div>

	<?php if ($totalPages > $currentPage) { ?>
	<div class="ccm-conversation-load-more-messages">
		<button class="btn btn-large" type="button" data-load-page="conversation-message-list" data-total-pages="<?php echo $totalPages?>" data-next-page="<?php echo $currentPage + 1?>" ><?php echo t('Load More')?></button>
	</div>
	<?php } ?>


</div>

<?php Loader::element('conversation/message/add_form', array(
	'blockAreaHandle' => $blockAreaHandle,
	'cID' => $cID,
	'bID' => $bID,
	'editor' => $editor,
	'addMessageLabel' => $addMessageLabel,
	'attachmentsEnabled' => $attachmentsEnabled,
	'displayForm' => $displayForm,
	'displayPostingForm' => $displayPostingForm,
	'position' => 'bottom',
	'enablePosting' => $enablePosting,
	'conversation' => $conversation
));?>