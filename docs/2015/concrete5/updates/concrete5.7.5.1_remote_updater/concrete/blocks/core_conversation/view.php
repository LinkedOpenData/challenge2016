<?php defined('C5_EXECUTE') or die("Access Denied.");
$paginate = ($paginate) ? 'true' : 'false';
$itemsPerPage = ($paginate) ? $itemsPerPage : -1;
$blockAreaHandle = $this->block->getAreaHandle();
/** @var \Concrete\Core\Permission\IPService $iph */
$iph = Core::make('helper/validation/ip');
$commentRatingIP = $iph->getRequestIP()->getIp();
$u = new User();
if ($u->isLoggedIn()) {
    $uID = $u->getUserID();
    $maxFileSize = $maxFileSizeRegistered;
    $maxFiles = $maxFilesRegistered;
}else{
    $maxFileSize = $maxFileSizeGuest;
    $maxFiles = $maxFilesGuest;
    $uID = 0;
}

if (is_object($conversation)) {
    ?>
    <div class="ccm-conversation-wrapper" data-conversation-id="<?php echo $conversation->getConversationID()?>">
    <?php echo t('Loading Conversation')?> <i class="fa fa-spin fa-circle-o-notch"></i>
    </div>

    <script type="text/javascript">
    $(function() {
        $('div[data-conversation-id=<?php echo $conversation->getConversationID()?>]').concreteConversation({
            cnvID: <?php echo $conversation->getConversationID()?>,
            blockID: <?php echo $bID?>,
            cID: <?php echo $cID?>,
            posttoken: '<?php echo $posttoken?>',
            displayMode: '<?php echo $displayMode?>',
            addMessageLabel: '<?php echo $addMessageLabel?>',
            paginate: <?php echo $paginate?>,
            itemsPerPage: <?php echo $itemsPerPage?>,
            orderBy: '<?php echo $orderBy?>',
            enableOrdering: <?php echo $enableOrdering?>,
            displayPostingForm: '<?php echo $displayPostingForm?>',
            activeUsers: <?php echo Loader::helper('json')->encode($users)?>,
            enableCommentRating: <?php echo $enableCommentRating?>,
            commentRatingUserID: <?php echo $uID?>,
            commentRatingIP: '<?php echo $commentRatingIP?>',
            dateFormat: '<?php echo $dateFormat?>',
            customDateFormat: '<?php echo $customDateFormat?>',
            blockAreaHandle: '<?php echo $blockAreaHandle ?>',
            fileExtensions: '<?php echo $fileExtensions?>',
            maxFileSize: '<?php echo $maxFileSize?>',
            maxFiles: '<?php echo $maxFiles?>',
            attachmentsEnabled: '<?php echo $attachmentsEnabled?>',
            attachmentOverridesEnabled: '<?php echo $attachmentOverridesEnabled?>'
        });
    });
    </script>
<?php } ?>