<?php    defined('C5_EXECUTE') or die("Access Denied."); ?>
<fieldset>
    <legend><?php   echo t('Select to display.'); ?></legend>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('fblike', 1, $fblike); ?>
            <?php  echo t("Facebook's Like"); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('tweet', 1, $tweet); ?>
            <?php  echo t("Twitter's Tweet"); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('gplus', 1, $gplus); ?>
            <?php  echo t("Google+'s plus one"); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('bhatena', 1, $bhatena); ?>
            <?php  echo t('Hatena bookmark'); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('tumblr', 1, $tumblr); ?>
            <?php  echo t("Tumblr's Share"); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('pinterest', 1, $pinterest); ?>
            <?php  echo t("Pinterest's Pin it"); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('linkedin', 1, $linkedin); ?>
            <?php  echo t("LinkedIn's Share"); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('pocket', 1, $pocket); ?>
            <?php  echo t('Pocket Button'); ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <?php  echo $form->checkbox('line', 1, $line); ?>
            <?php  echo t('LINE Button'); ?>
        </label>
    </div>
</fieldset>