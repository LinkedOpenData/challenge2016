<form action="<?php echo View::action('save') ?>" method="post">
    <div class="checkbox">
        <label>
            <input name="show_titles" value="1" type="checkbox" <?php echo $show_titles ? 'checked' : '' ?> />
            <?php echo t('Enable Toolbar Titles') ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input name="increase_font_size" value="1" type="checkbox" <?php echo $increase_font_size ? 'checked' : '' ?> />
            <?php echo t('Increase Toolbar Font Size') ?>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input name="display_help" value="1" type="checkbox" <?php echo $display_help ? 'checked' : '' ?> />
            <?php echo t('Enable Help') ?>
        </label>
    </div>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-primary">
                <?php echo t('Save')?>
            </button>
        </div>
    </div>
</form>
