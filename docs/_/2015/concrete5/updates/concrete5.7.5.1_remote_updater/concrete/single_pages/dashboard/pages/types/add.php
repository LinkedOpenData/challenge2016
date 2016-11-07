<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<form method="post" action="<?php echo $view->action('submit')?>">
<div class="ccm-pane-body">
<?php echo Loader::element('page_types/form/base');?>
</div>
<div class="ccm-dashboard-form-actions-wrapper">
    <div class="ccm-dashboard-form-actions">
        <a href="<?php echo URL::to('/dashboard/pages/types')?>" class="btn btn-default"><?php echo t('Cancel')?></a>
    	<button class="pull-right btn btn-primary" type="submit"><?php echo t('Add')?></button>
    </div>
</div>
</form>