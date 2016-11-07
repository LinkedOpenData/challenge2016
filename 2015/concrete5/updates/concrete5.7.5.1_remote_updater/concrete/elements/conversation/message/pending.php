<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
$class = 'ccm-conversation-message ccm-conversation-message-level' . $message->getConversationMessageLevel();
$cnvID = $message->getConversationID();
$cnvMessageID = $message->getConversationMessageID();
?>

<div data-conversation-message-id="<?php echo $message->getConversationMessageID()?>" data-conversation-message-level="<?php echo $message->getConversationMessageLevel()?>" class="<?php echo $class?>">
	<a id="cnv<?php echo $cnvID?>Message<?php echo $cnvMessageID?>"></a>
	<div class="ccm-conversation-message-user">
		<div class="ccm-conversation-avatar"><?php print Loader::helper('concrete/avatar')->outputUserAvatar($ui)?></div>
		<div class="ccm-conversation-message-byline">
				<span class="ccm-conversation-message-username"><?php
					$author = $message->getConversationMessageAuthorObject();
					$formatter = $author->getFormatter();
					print $formatter->getDisplayName();
					?></span>
			<span class="ccm-conversation-message-divider">|</span>
			<span class="ccm-conversation-message-date"><?php echo $message->getConversationMessageDateTimeOutput($dateFormat);?></span>
		</div>

	</div>
	<div class="ccm-conversation-message-body">
		<div class="ccm-conversation-message-pending-notice alert alert-info">
			<?php echo t('This message is pending approval by a moderator.')?>
		</div>
	</div>
</div>