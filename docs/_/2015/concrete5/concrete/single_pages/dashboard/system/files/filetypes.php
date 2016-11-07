<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Allowed File Types'), false, 'span8 offset2', false)?>

    <form method="post" id="file-access-extensions" action="<?php echo $view->action('file_access_extensions')?>" role="form">
        <?php echo $validation_token->output('file_access_extensions');?>
        <p>
            <?php echo t('Only files with the following extensions will be allowed. Separate extensions with commas. Periods and spaces will be ignored.')?>
        </p>
        <?php if (UPLOAD_FILE_EXTENSIONS_CONFIGURABLE) { ?>
            <div class="form-group">
                <textarea name="file-access-file-types" class="form-control" rows="3"><?php echo $file_access_file_types?></textarea>
            </div>
        <?php } else { ?>
            <?php echo $file_access_file_types?>
        <?php } ?>
	
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button class="pull-right btn btn-primary" type="submit" value="file-access-extensions"><?php echo t('Save')?></button>
            </div>
        </div>	        
    </form>

    <?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>