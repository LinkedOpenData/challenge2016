<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php if ($this->controller->getTask() == 'add'
    || $this->controller->getTask() == 'do_add'
    || $this->controller->getTask() == 'edit'
    || $this->controller->getTask() == 'update'
    || $this->controller->getTask() == 'delete') { ?>

    <?php
    if (is_object($type)) {
        $ftTypeName = $type->getName();
        $ftTypeHandle = $type->getHandle();
        $ftTypeWidth = $type->getWidth();
        $ftTypeHeight = $type->getHeight();
        $ftTypeIsRequired = $type->isRequired();
        $method = 'update';

        if (!$ftTypeIsRequired) { ?>

            <div class="ccm-dashboard-header-buttons">
                <form method="post" action="<?php echo $this->action('delete')?>">
                    <input type="hidden" name="ftTypeID" value="<?php echo $type->getID()?>" />
                    <?php echo Loader::helper('validation/token')->output('delete');?>
                    <button type="button" class="btn btn-danger" data-action="delete-type"><?php echo t('Delete Type')?></button>
                </form>
            </div>

        <?php
        }

    } else {
        $method = 'do_add';
    }
    ?>

    <form method="post" action="<?php echo $view->action($method)?>" id="ccm-attribute-key-form">
        <?php echo Loader::helper('validation/token')->output($method);?>
        <?php if (is_object($type)) { ?>
            <input type="hidden" name="ftTypeID" value="<?php echo $type->getID()?>" />
        <?php } ?>
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('ftTypeHandle', t('Handle'))?>
                <div class="input-group">
                    <?php echo $form->text('ftTypeHandle', $ftTypeHandle)?>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->label('ftTypeName', t('Name'))?>
                <div class="input-group">
                    <?php echo $form->text('ftTypeName', $ftTypeName)?>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->label('ftTypeWidth', t('Width'))?>
                <div class="input-group">
                    <?php echo $form->text('ftTypeWidth', $ftTypeWidth)?>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->label('ftTypeHeight', t('Height'))?>
                <?php echo $form->text('ftTypeHeight', $ftTypeHeight)?>
            </div>
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo t('Only place a value in here if you want this thumbnail to force its dimensions to the width and height.')?></div>
        </fieldset>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo URL::page($c)?>" class="btn pull-left btn-default"><?php echo t('Back')?></a>
                <?php if (is_object($type)) { ?>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo t('Save')?></button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo t('Add')?></button>
                <?php } ?>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        $(function() {
            $('button[data-action=delete-type]').on('click', function(e) {
                e.preventDefault();
                if (confirm('<?php echo t('Delete this thumbnail type?')?>')) {
                    $(this).closest('form').submit();
                }
            });
        })
    </script>

<?php } else { ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?php echo $view->action('add')?>" class="btn btn-primary"><?php echo t("Add Type")?></a>
    </div>

    <table class="table">
    <thead>
    <tr>
        <th><?php echo t('Handle')?></th>
        <th><?php echo t('Name')?></th>
        <th><?php echo t('Width')?></th>
        <th><?php echo t('Height')?></th>
        <th><?php echo t('Required')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($types as $type) { ?>
    <tr>
        <td><a href="<?php echo $view->action('edit', $type->getID())?>"><?php echo $type->getHandle()?></a></td>
        <td><?php echo $type->getDisplayName()?></td>
        <td><?php echo $type->getWidth()?></td>
        <td><?php echo ($type->getHeight()) ? $type->getHeight() : '<span class="text-muted">' . t('Automatic') . '</span>' ?></td>
        <td><?php echo ($type->isRequired()) ? t('Yes') : t('No')?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>
<?php } ?>