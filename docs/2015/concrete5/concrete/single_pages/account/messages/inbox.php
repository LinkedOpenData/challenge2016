<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>

<div class="row">
<div class="col-sm-10 col-sm-offset-1">

<div class="page-header">
<h1><?php echo t("Private Messages")?></h1>
</div>

    	<?php switch($this->controller->getTask()) {
    		case 'view_message': ?>

			<?php echo Loader::helper('concrete/ui')->tabs(array(
				array($view->action('view_mailbox', 'inbox'), t('Inbox'), $box == 'inbox'),
				array($view->action('view_mailbox', 'sent'), t('Sent'), $box == 'sent')
			), false)?>

    		<div id="ccm-private-message-detail">
				<a href="<?php echo $view->url('/members/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $av->outputUserAvatar($msg->getMessageRelevantUserObject())?></a>
				<a href="<?php echo $view->url('/members/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $msg->getMessageRelevantUserName()?></a>

				<div id="ccm-private-message-actions">

				<div class="btn-toolbar">

				<div class="btn-group">
				<a href="<?php echo $backURL?>" class="btn btn-small"><i class="icon-arrow-left"></i> <?php echo t('Back to Messages')?></a>
				</div>

				<div class="btn-group">
				<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-cog"></i> <?php echo t('Action')?>
				&nbsp;
				<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
				<?php $u = new User(); ?>
				<?php if ($msg->getMessageAuthorID() != $u->getUserID()) { ?>
					<?php
					$mui = $msg->getMessageRelevantUserObject();
					if (is_object($mui)) {
						if ($mui->getUserProfilePrivateMessagesEnabled()) { ?>
							<li><a href="<?php echo $view->action('reply', $box, $msg->getMessageID())?>"><?php echo t('Reply')?></a>
							<li class="divider"></li>
						<?php }
					}?>
				<?php } ?>
				<li><a href="javascript:void(0)" onclick="if(confirm('<?php echo t('Delete this message?')?>')) { window.location.href='<?php echo $deleteURL?>'}; return false"><?php echo t('Delete')?></a>
				</ul>
				</div>
				</div>

				</div>

				<strong><?php echo $subject?></strong>
				<time><?php echo $dateAdded?></time>
				<br/><br/>

    			<div>
   				<?php echo $msg->getFormattedMessageBody()?>
   				</div>
			</div>


    		<?php
    			break;
    		case 'view_mailbox': ?>

                <a href="<?php echo URL::to('/account')?>" class="btn btn-default pull-right" /><?php echo t('Back to Account')?></a>

                <?php echo Loader::helper('concrete/ui')->tabs(array(
				array($view->action('view_mailbox', 'inbox'), t('Inbox'), $mailbox == 'inbox'),
				array($view->action('view_mailbox', 'sent'), t('Sent'), $mailbox == 'sent')
			), false)?>


			<table class="ccm-profile-messages-list table-striped table" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th><?php if ($mailbox == 'sent') { ?><?php echo t('To')?><?php } else { ?><?php echo t('From')?><?php } ?></th>
				<th><?php echo t('Subject')?></th>
				<th><?php echo t('Sent At')?></th>
				<th><?php echo t('Status')?></th>
			</tr>
			</thead>
			<tbody>


    		<?php
    			if (is_array($messages)) {
					foreach($messages as $msg) { ?>

					<tr>
						<td class="ccm-profile-message-from">
						<a href="<?php echo $view->url('/members/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $av->outputUserAvatar($msg->getMessageRelevantUserObject())?></a>
						<a href="<?php echo $view->url('/members/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $msg->getMessageRelevantUserName()?></a>
						</td>
						<td class="ccm-profile-messages-item-name"><a href="<?php echo $view->url('/account/messages/inbox', 'view_message', $mailbox, $msg->getMessageID())?>"><?php echo $msg->getFormattedMessageSubject()?></a></td>
						<td style="white-space: nowrap"><?php echo $dh->formatDateTime($msg->getMessageDateAdded(), true)?></td>
						<td><?php echo $msg->getMessageStatus()?></td>
					</tr>



				<?php } ?>
			<?php } else { ?>
				<tr>
					<Td colspan="4"><?php echo t('No messages found.')?></td>
				</tr>
			<?php } ?>
			</tbody>
			</table>


			<?php

				$messageList->displayPaging();
    			break;
    		case 'reply_complete': ?>

    		<div class="alert alert-success"><?php echo t('Reply Sent.')?></div>
    		<a href="<?php echo $view->url('/account/messages/inbox', 'view_message', $box, $msgID)?>" class="btn btn-default"><?php echo t('Back to Message')?></a>

    		<?php
    			break;
    		case 'send_complete': ?>

    		<div class="alert alert-success"><?php echo t('Message Sent.')?></div>
    		<a href="<?php echo $view->url('/members/profile', 'view', $recipient->getUserID())?>" class="btn btn-default"><?php echo t('Back to Profile')?></a>

    		<?php
    			break;
			case 'over_limit': ?>
				<h2><?php echo t('Woops!')?></h2>
				<p><?php echo t("You've sent more messages than we can handle just now, that last one didn't go out.
				We've notified an administrator to check into this.
				Please wait a few minutes before sending a new message."); ?></p>
				<?php break;
    		case 'send':
    		case 'reply':
    		case 'write': ?>

			<div id="ccm-profile-message-compose">
				<form method="post" action="<?php echo $view->action('send')?>">

				<?php echo $form->hidden("uID", $recipient->getUserID())?>
				<?php if ($this->controller->getTask() == 'reply') { ?>
					<?php echo $form->hidden("msgID", $msgID)?>
					<?php echo $form->hidden("box", $box)?>
				<?php
					$subject = t('Re: %s', $text->entities($msgSubject));
				} else {
					$subject = $text->entities($msgSubject);
				}
				?>

				<h4><?php echo t('Send a Private Message')?></h4>

				<div class="form-group">
					<label class="control-label"><?php echo t("To")?></label>
					<input disabled="disabled" class="form-control" type="text" value="<?php echo $recipient->getUserName()?>" class="span5" />
				</div>

				<div class="form-group">
					<?php echo $form->label('subject', t('Subject'))?>
					<?php echo $form->text('msgSubject', $subject, array('class' => 'span5'))?>
				</div>

				<div class="form-group">
					<?php echo $form->label('body', t('Message'))?>
					<?php echo $form->textarea('msgBody', $msgBody, array('rows'=>8, 'class' => 'span5'))?>
				</div>

                <?php echo $form->submit('button_submit', t('Send Message'), array('class' => 'pull-right btn btn-primary'))?>
                <?php echo $form->submit('button_cancel', t('Cancel'), array('class' => 'btn-default', 'onclick' => 'window.location.href=\'' . $backURL . '\'; return false'))?>

				<?php echo $valt->output('validate_send_message');?>

				</form>

			</div>


    		<?php break;

    		default:
    			// the inbox and sent box and other controls ?>

    			<table class="table table-striped" border="0" cellspacing="0" cellpadding="0">
    			<tr>
    				<th class="ccm-profile-messages-item-name"><?php echo t('Mailbox')?></th>
    				<th><?php echo t('Messages')?></th>
    				<th><?php echo t('Latest Message')?></th>
    			</tr>
    			<tr>
    				<td class="ccm-profile-messages-item-name"><a href="<?php echo $view->action('view_mailbox', 'inbox')?>"><?php echo t('Inbox')?></a></td>
    				<td><?php echo $inbox->getTotalMessages()?></td>
    				<td class="ccm-profile-mailbox-last-message"><?php
    				$msg = $inbox->getLastMessageObject();
    				if (is_object($msg)) {
    					print t('<strong>%s</strong>, sent by %s on %s', $msg->getFormattedMessageSubject(), $msg->getMessageAuthorName(), $dh->formatDateTime($msg->getMessageDateAdded(), true));
    				}
    				?></td>
    			</tr>
    			<tr>
    				<td class="ccm-profile-messages-item-name"><a href="<?php echo $view->action('view_mailbox', 'sent')?>"><?php echo t('Sent Messages')?></a></td>
    				<td><?php echo $sent->getTotalMessages()?></td>
    				<td class="ccm-profile-mailbox-last-message"><?php
     				$msg = $sent->getLastMessageObject();
    				if (is_object($msg)) {
    					print t('<strong>%s</strong>, sent by %s on %s', $msg->getFormattedMessageSubject(), $msg->getMessageAuthorName(), $dh->formatDateTime($msg->getMessageDateAdded(), true));
    				}
    				?>
   				</td>
    			</tr>
    			</table>

                <div class="form-actions">
                    <a href="<?php echo URL::to('/account')?>" class="btn btn-default" /><?php echo t('Back to Account')?></a>
                </div>

            <?php
    			break;
    	} ?>


</div>
</div>
