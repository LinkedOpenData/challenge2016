<?php
defined('C5_EXECUTE') or die("Access Denied.");

$subject = $siteName.' '.t('Registration Approved');

/**
 * HTML BODY START
 */
ob_start();

?>
<h2><?php echo t('Welcome to') ?> <?php echo $siteName ?></h2>
<?php echo t("Your registration has been approved. You can log into your new account here") ?>:<br />
<br />
<a href="<?php echo View::url('/login') ?>"><?php echo View::url('/login') ?></a>
<?php

$bodyHTML = ob_get_clean();
/**
 * HTML BODY END
 *
 * =====================
 *
 * PLAIN TEXT BODY START
 */
ob_start();

?>
<?php echo t('Welcome to') ?> <?php echo $siteName ?>

<?php echo t("Your registration has been approved. You can log into your new account here") ?>:

<?php echo View::url('/login') ?>
<?php

$body = ob_get_clean();
/**
 * PLAIN TEXT BODY END
 */
