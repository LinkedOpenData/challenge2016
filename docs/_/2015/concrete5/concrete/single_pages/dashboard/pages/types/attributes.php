<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<p class="lead"><?php echo $pagetype->getPageTypeDisplayName(); ?></p>

<div class="alert alert-info"><?php echo t('Attributes set here will automatically be applied to new pages of that type.')?></div>

<div data-container="editable-fields">

<?php Loader::element('attribute/editable_list', array(
    'attributes' => $attributes,
    'object' => $defaultPage,
    'saveAction' => $view->action('update_attribute', $pagetype->getPageTypeID()),
    'clearAction' => $view->action('clear_attribute', $pagetype->getPageTypeID()),
    'permissionsCallback' => function($ak) {
        return true;
    }
));?>

</div>


<script type="text/javascript">
    $(function() {
        $('div[data-container=editable-fields]').concreteEditableFieldContainer({
            url: '<?php echo $view->action('save', $pagetype->getPageTypeID())?>',
            data: {
                ccm_token: '<?php echo Loader::helper('validation/token')->generate()?>'
            }
        });
    });
</script>

<div class="ccm-dashboard-header-buttons">
    <a href="<?php echo URL::to('/dashboard/pages/types')?>" class="btn btn-default"><?php echo t('Back to List')?></a>
</div>
