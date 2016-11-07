<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$bp = new Permissions($b);
?>
<div class="ccm-ui">
    <form method="post" data-dialog-form="block-cache" action="<?php echo $controller->action('submit')?>">

    <?php if ($bp->canEditBlockName()) { ?>
    <fieldset>
        <legend><?php echo t('Name')?></legend>
        <div class="form-group">
            <label class="control-label" for="bName">
                <?php echo t('Block Name')?>
                <i class="fa fa-question-circle launch-tooltip" title="<?php echo t('This can be useful when working with a block programmatically. This is rarely used or needed.')?>"></i>
            </label>
            <input type="text" class="form-control" name="bName" id="bName" value="<?php echo $bName?>">
        </div>
    </fieldset>
    <?php } ?>

    <?php if ($bp->canEditBlockCacheSettings()) { ?>
    <fieldset>
        <legend><?php echo t('Caching')?></legend>
        <?php if (!Config::get('concrete.cache.blocks')) { ?>
            <div class="alert alert-warning"><?php echo t('Block caching is currently disabled globally. These settings won\'t take affect until block caching is turned on. You can turn these settings on from the <a href="%s">Cache and Speed Settings</a> page in the Dashboard.', URL::to('/dashboard/system/optimization/cache'))?></div>
        <?php } ?>

        <div class="form-group">
            <label class="control-label"><?php echo t('Override Block Type')?></label>
            <div class="checkbox">
            <label>
                <?php echo $form->checkbox('cbOverrideBlockTypeCacheSettings', 1, $cbOverrideBlockTypeCacheSettings)?>
                <?php echo t('Override block type cache settings.')?>
            </label>
            </div>
        </div>
        <div class="form-group" data-settings="block-cache">
            <label class="control-label"><?php echo t('Settings')?></label>
            <div class="checkbox">
            <label>
                <?php echo $form->checkbox('btCacheBlockOutput', 1, $btCacheBlockOutput)?>
                <?php echo t('Cache block output.')?>
            </label>
            </div>
            <div class="checkbox">
            <label>
                <?php echo $form->checkbox('btCacheBlockOutputForRegisteredUsers', 1, $btCacheBlockOutputForRegisteredUsers)?>
                <?php echo t('Cache block output even for logged in users.')?>
            </label>
            </div>
            <div class="checkbox">
            <label>
                <?php echo $form->checkbox('btCacheBlockOutputOnPost', 1, $btCacheBlockOutputOnPost)?>
                <?php echo t('Cache block output on HTTP POST.')?>
            </label>
            </div>
        </div>
        <div class="form-group" data-settings="block-cache">
            <label class="control-label" for="btCacheBlockOutputLifetime">
                <?php echo t('Cache for how long (in seconds)?')?>
            </label>
            <input type="text" class="form-control" name="btCacheBlockOutputLifetime" id="btCacheBlockOutputLifetime" value="<?php echo $btCacheBlockOutputLifetime?>">
        </div>
    </fieldset>
    <?php } ?>

    <div class="dialog-buttons">
        <button class="btn btn-default pull-left" data-dialog-action="cancel"><?php echo t('Cancel')?></button>
        <button type="button" data-dialog-action="submit" class="btn btn-primary pull-right"><?php echo t('Save')?></button>
    </div>

    </form>
</div>

<script type="text/javascript">

    $(function() {
        $('input[name=cbOverrideBlockTypeCacheSettings]').on('change', function() {
            if ($(this).is(':checked')) {
                $('div[data-settings=block-cache]').show();
            } else {
                $('div[data-settings=block-cache]').hide();
            }
        }).trigger('change');
    });
</script>