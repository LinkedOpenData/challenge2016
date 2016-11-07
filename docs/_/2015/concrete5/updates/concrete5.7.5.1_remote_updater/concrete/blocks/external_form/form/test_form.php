<?php
$form = Loader::helper('form');
defined('C5_EXECUTE') or die("Access Denied.");
if (isset($response)) { ?>
	<div class="alert alert-info"><?php echo $response?></div>
<?php } ?>


<form method="post" action="<?php echo $view->action('test_search')?>">

    <p><?php echo $message?></p>

    <div class="form-group">
        <label class="control-label"><?php echo t('Test')?></label>
        <?php echo $form->text('test_text_field')?>
    </div>

    <div class="form-group">
        <input type="submit" name="submit" value="submit" class="btn btn-default" />
    </div>

</form>