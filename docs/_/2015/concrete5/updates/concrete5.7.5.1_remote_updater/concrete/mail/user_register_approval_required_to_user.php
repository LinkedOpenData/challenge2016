<?php
defined('C5_EXECUTE') or die("Access Denied.");

$subject = $siteName.' '.t("Registration - Approval Required");

/**
 * HTML BODY START
 */
ob_start()

?>
<h2><?php echo t('Registration Approval Required') ?></h2>
<?php echo t("You have registered on %s. Your account will be approved by the administrator.", $siteName) ?><br />
<?php echo t('User Name') ?>: <b><?php echo $uName ?></b><br />
<?php echo t('Email') ?>: <b><?php echo $uEmail ?></b><br />
<br />

<?php

$bodyHTML = ob_get_clean();
/**
 * HTML BODY END
 *
 * ======================
 *
 * PLAIN TEXT BODY START
 */
ob_start();

?>
<?php echo t('Registration Approval Required') ?>

<?php echo t("You have registered on %s. Your account will be approved by the administrator.", $siteName) ?>

<?php echo t('User Name') ?>: <?php echo $uName ?>
<?php echo t('Email') ?>: <?php echo $uEmail ?>

<?php

$body = ob_get_clean();
/**
 * PLAIN TEXT BODY END
 */
