<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php 
$form = Loader::helper('form'); 
$ih = Loader::helper("concrete/ui");
$valt = Loader::helper('validation/token');

$type = $workflow->getWorkflowTypeObject();

?>
<div class="ccm-dashboard-header-buttons">
    <div class="pull-right">
        <?php if (is_object($workflow)) { ?>

            <?php
            $valt = Loader::helper('validation/token');
            $ih = Loader::helper('concrete/ui');
            $delConfirmJS = t('Are you sure you want to remove this workflow?');
            ?>
            <script type="text/javascript">
                deleteWorkflow = function() {
                    if (confirm('<?php echo $delConfirmJS?>')) {
                        location.href = "<?php echo $view->action('delete', $workflow->getWorkflowID(), $valt->generate('delete_workflow'))?>";
                    }
                }
            </script>

            <?php print $ih->button_js(t('Delete Workflow'), "deleteWorkflow()", '', 'btn-danger');?>
        <?php } ?>
        <?php
        if ($type->getPackageID() > 0) {
            Loader::packageElement('workflow/types/' . $type->getWorkflowTypeHandle() . '/type_form_buttons', $type->getPackageHandle(), array('type' => $type, 'workflow' => $workflow));
        } ?>
        <a href="<?php echo $view->action('edit_details', $workflow->getWorkflowID())?>" class="btn btn-primary"><?php echo t('Edit Details')?></a>
    </div>
</div>
<input type="hidden" name="wfID" value="<?php echo $workflow->getWorkflowID()?>" />

<h3><?php echo $workflow->getWorkflowDisplayName()?> <small><?php echo $type->getWorkflowTypeName()?></small></h3>

<?php 
if ($type->getPackageID() > 0) { 
	Loader::packageElement('workflow/types/' . $type->getWorkflowTypeHandle()  . '/type_form', $type->getPackageHandle(), array('type' => $type, 'workflow' => $workflow));
} else {
	Loader::element('workflow/types/' . $type->getWorkflowTypeHandle() . '/type_form', array('type' => $type, 'workflow' => $workflow));
}
?>

<div class="ccm-dashboard-form-actions-wrapper">
    <div class="ccm-dashboard-form-actions">
        <a href="<?php echo URL::to('/dashboard/workflow/workflows')?>" class="btn btn-default pull-left"><?php echo t('Back to List')?></a>

    </div>
</div>
