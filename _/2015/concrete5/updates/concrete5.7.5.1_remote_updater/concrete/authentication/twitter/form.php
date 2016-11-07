<?php
use Concrete\Core\Validation\CSRF\Token;

defined('C5_EXECUTE') or die('Access Denied');
if (isset($error)) {
    ?>
    <div class="alert alert-danger"><?php echo $error ?></div>
    <?php
}
if (isset($message)) {
    ?>
    <div class="alert alert-success"><?php echo $message ?></div>
<?php
}


if (isset($show_email) && $show_email) {
    ?>
    <form action="<?php echo \URL::to('/login/callback/twitter/handle_register') ?>">
        <span><?php echo t('Register an account for "%s"', "@{$username}") ?></span>
        <hr />
        <div class="input-group">
            <input type="email" name="uEmail" placeholder="email" class="form-control" />
            <span class="input-group-btn">
                <button class="btn btn-primary"><?php echo t('Register') ?></button>
            </span>
        </div>
        <?php echo id(new Token)->output('twitter_register'); ?>
    </form>
    <?php
} else {

    $user = new User;

    if ($user->isLoggedIn()) {
        ?>
        <div class="form-group">
            <span>
                <?php echo t('Attach a %s account', t('twitter')) ?>
            </span>
            <hr>
        </div>
        <div class="form-group">
            <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/twitter/attempt_attach'); ?>"
               class="btn btn-primary btn-twitter btn-block">
                <i class="fa fa-twitter"></i>
                <?php echo t('Attach a %s account', t('twitter')) ?>
            </a>
        </div>
    <?php
    } else {
        ?>
        <div class="form-group">
            <span>
                <?php echo t('Sign in with %s', t('twitter')) ?>
            </span>
            <hr>
        </div>
        <div class="form-group">
            <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/twitter/attempt_auth'); ?>"
               class="btn btn-primary btn-twitter btn-block">
                <i class="fa fa-twitter"></i>
                <?php echo t('Log in with %s', 'twitter') ?>
            </a>
        </div>
    <?php
    }
    ?>
    <style>
        .ccm-ui .btn-twitter {
            border-width: 0px;
            background: #00aced;
        }

        .btn-twitter .fa-twitter {
            margin: 0 6px 0 3px;
        }
    </style>
<?php
}
?>
