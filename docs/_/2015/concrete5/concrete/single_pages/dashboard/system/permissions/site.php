<?php defined('C5_EXECUTE') or die("Access Denied.");

$h = Loader::helper('concrete/dashboard');
$ih = Loader::helper('concrete/ui');
$form = Loader::helper('form');
?>
<?php echo $h->getDashboardPaneHeaderWrapper(t('Site Access'), false, false, false);?>
<form id="site-permissions-form" action="<?php echo $view->action('')?>" method="post" role="form">
	<?php echo $this->controller->token->output('site_permissions_code')?>
	
    <?php if(Config::get('concrete.permissions.model') != 'simple'):?>
    <div>
        <p>
            <?php echo t('Your concrete5 site does not use the simple permissions model. You must change your permissions for each specific page and content area.')?>
        </p>
    </div>
    <?php else:?>
    
    <fieldset>
	<legend style="margin-bottom: 0px"><?php echo t('Viewing Permissions')?></legend>
	<div class="form-group">
        <div class="radio">
            <label>
		    <?php echo $form->radio('view', 'ANYONE', $guestCanRead)?>
		    <span><?php echo t('Public')?> - <?php echo t('Anyone may view the website.')?></span>
                </label>
        </div>
		 
        <div class="radio">
            <label>
            <?php echo $form->radio('view', 'USERS', $registeredCanRead)?>
            <span><?php echo t('Members')?> - <?php echo t('Only registered users may view the website.')?></span>
            </label>
        </div>

		<div class="radio">
            <label>
			<?php echo $form->radio('view', 'PRIVATE', !$guestCanRead && !$registeredCanRead)?>
			<span><?php echo t('Private')?> - <?php echo t('Only the administrative group may view the website.')?></span>
            </label>
		</div>
    </div>
    </fieldset>
    
    <fieldset>
    <legend style="margin-bottom: 0px"><?php echo t('Edit Access')?></legend>
        <span class="help-block"><?php echo t('Choose which users and groups may edit your site. Note: These settings can be overridden on specific pages.')?></span>
        <?php foreach($gArray as $g):?>
            <div class="checkbox">
                <label>
                    <?php echo $form->checkbox('gID[]', $g->getGroupID(), in_array($g->getGroupID(), $editAccess))?>
                    <span><?php echo $g->getGroupDisplayName()?></span>
                </label>
            </div>
        <?php endforeach?>
    </fieldset>
    
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-primary" type="submit" ><?php echo t('Save')?></button>
        </div>
    </div>

<?php endif?>
</form>
<?php echo $h->getDashboardPaneFooterWrapper(false);?>
