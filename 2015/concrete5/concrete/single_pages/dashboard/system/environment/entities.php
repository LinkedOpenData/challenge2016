<?php
defined('C5_EXECUTE') or die("Access Denied.");

?>

<form method="post" id="entities-settings-form" action="<?php echo $view->action('update_entity_settings') ?>">
    <?php echo $this->controller->token->output('update_entity_settings') ?>

    <fieldset style="margin-bottom:15px;">
        <legend><?php echo t('Settings') ?></legend>

        <label class="launch-tooltip" data-placement="right" title="<?php echo t('Defines whether the Doctrine proxy classes are created on the fly. On the fly generation is active when development mode is enabled.') ?>"><?php echo t('Doctrine Development Mode') ?></label>

        <div class="radio">
            <label>
                <input type="radio" name="DOCTRINE_DEV_MODE" value="1" <?php if (Config::get('concrete.cache.doctrine_dev_mode')) { ?> checked <?php } ?> />
                <span><?php echo t('On - Proxy classes will be generated on the fly. Good for development.')?></span>
            </label>
        </div>

        <div class="radio">
            <label>
                <input type="radio" name="DOCTRINE_DEV_MODE" value="0" <?php if (!Config::get('concrete.cache.doctrine_dev_mode')) { ?> checked <?php } ?> />
                <span><?php echo t('Off - Proxy classes need to be manually generated. Helps speed up a live site.') ?></span>
            </label>
        </div>
    </fieldset>

    <div class="well clearfix">
        <?php echo $interface->submit(t('Save'), 'entities-settings-form', 'right', 'btn-primary') ?>
    </div>
</form>

<form method="post" id="entities-refresh-form" action="<?php echo $view->action('refresh_entities') ?>">
    <?php echo $this->controller->token->output('refresh_entities') ?>

    <fieldset>
        <legend><?php echo t("Entities")?></legend>

        <p><?php echo t("Search for application specific entities, refresh their database schema and generate their proxy classes.") ?></p>

        <?php echo $interface->submit(tc('Doctrine', 'Refresh Entities'), 'entities-refresh-form', 'left', 'btn-default') ?>
    </fieldset>
</form>
