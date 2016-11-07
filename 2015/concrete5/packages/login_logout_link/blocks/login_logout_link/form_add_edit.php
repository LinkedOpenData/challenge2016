<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="form-group">
    <?php  echo $form->label('loginLabel', t('Custom Login Text'))?>
    <?php  echo $form->text('loginLabel', $loginLabel); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('logoutLabel', t('Custom Logout Text'))?>
    <?php  echo $form->text('logoutLabel', $logoutLabel); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('formatting', t('Formatting Style'))?>
    <select class="form-control" name="formatting" id="formatting">
        <option value="p" <?php  echo ($this->controller->formatting=="p"?"selected":"")?>><?php  echo t('P')?></option>
        <option value="h1" <?php  echo ($this->controller->formatting=="h1"?"selected":"")?>><?php  echo t('H1')?></option>
        <option value="h2" <?php  echo ($this->controller->formatting=="h2"?"selected":"")?>><?php  echo t('H2')?></option>
        <option value="h3" <?php  echo ($this->controller->formatting=="h3"?"selected":"")?>><?php  echo t('H3')?></option>
        <option value="h4" <?php  echo ($this->controller->formatting=="h4"?"selected":"")?>><?php  echo t('H4')?></option>
        <option value="h5" <?php  echo ($this->controller->formatting=="h5"?"selected":"")?>><?php  echo t('H5')?></option>
        <option value="h6" <?php  echo ($this->controller->formatting=="h6"?"selected":"")?>><?php  echo t('H6')?></option>
        <option value="div" <?php  echo ($this->controller->formatting=="div"?"selected":"")?>><?php  echo t('DIV')?></option>
        <option value="span" <?php  echo ($this->controller->formatting=="span"?"selected":"")?>><?php  echo t('SPAN')?></option>
    </select>
</div>
