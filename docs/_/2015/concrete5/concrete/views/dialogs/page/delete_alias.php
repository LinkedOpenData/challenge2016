<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-ui">

    <form class="form-stacked" data-dialog-form="delete-alias" method="post" action="<?php echo $controller->action('submit')?>">

        <p><?php echo t('Remove this alias or external link?')?></p>

        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" data-dialog-action="cancel"><?php echo t('Cancel')?></button>
            <button type="button" data-dialog-action="submit" class="btn btn-danger pull-right"><?php echo t('Delete')?></button>
        </div>
    </form>

    <script type="text/javascript">
        $(function() {
            ConcreteEvent.unsubscribe('AjaxFormSubmitSuccess.sitemapDelete');
            ConcreteEvent.subscribe('AjaxFormSubmitSuccess.sitemapDelete', function(e, data) {
                if (data.form == 'delete-alias') {
                    ConcreteEvent.publish('SitemapDeleteRequestComplete', {'cID': '<?php echo $c->getCollectionID()?>'});
                }
            });
        });
    </script>

</div>
