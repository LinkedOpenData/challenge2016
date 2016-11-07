<?php
defined('C5_EXECUTE') or die('Access Denied');
?>
<div class="form-group">
            <span>
                <?php echo t('Attach a %s account', t('twitter')) ?>
            </span>
    <hr>
</div>
<div class="form-group">
    <a href="<?php echo \URL::to('/ccm/system/authentication/oauth2/twitter/attempt_attach'); ?>"
       class="btn btn-primary btn-twitter">
        <i class="fa fa-twitter"></i>
        <?php echo t('Attach a %s account', t('twitter')) ?>
    </a>
</div>
<style>
    .ccm-ui .btn-twitter {
        border-width: 0px;
        background: #00aced;
    }

    .btn-twitter .fa-twitter {
        margin: 0 6px 0 3px;
    }
</style>
