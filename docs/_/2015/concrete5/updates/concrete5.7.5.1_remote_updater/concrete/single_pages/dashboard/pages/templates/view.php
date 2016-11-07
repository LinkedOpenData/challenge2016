<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<?php if (is_object($template) && ($this->controller->getTask() == 'edit' || $this->controller->getTask() == 'update')) {
    $form = Loader::helper('form');
?>
      
    <form method="post" class="form-horizontal" id="update_page_template" action="<?php echo $view->url('/dashboard/pages/templates', 'update')?>">
    <?php echo $this->controller->token->output('update_page_template')?>
    <input type="hidden" name="pTemplateID" value="<?php echo $template->getPageTemplateID()?>" />

        <?php $confirmMsg = t('Are you sure?'); ?>
        <script type="text/javascript">
        deleteTemplate = function() {
            if(confirm('<?php echo $confirmMsg?>')){ 
                location.href="<?php echo $view->url('/dashboard/pages/templates/','delete',$template->getPageTemplateID(), $this->controller->token->generate('delete_page_template'))?>";
            }   
        }
        </script>


        
        <div class="form-group">
            <label for="pTemplateName" class="col-md-2 control-label"><?php echo t('Name')?></label>
            <div class="col-md-10">
                <?php echo $form->text('pTemplateName', $template->getPageTemplateName())?>
            </div>
        </div>

        <div class="form-group">
            <label for="pTemplateHandle" class="col-md-2 control-label"><?php echo t('Handle')?></label>
            <div class="col-md-10">
                <?php echo $form->text('pTemplateHandle', $template->getPageTemplateHandle())?>
            </div>
        </div>

        <div class="form-group">
            <label for="pTemplateHandle" class="col-md-2 control-label"><?php echo t('Icon')?></label>
            <div class="col-md-10">

            <?php
            $i = 0;
            foreach($icons as $ic) { ?>
              <div class="col-sm-2">
                <label style="text-align: center">
                     <img src="<?php echo REL_DIR_FILES_PAGE_TEMPLATE_ICONS.'/'.$ic;?>" class="img-responsive" style="vertical-align: middle" />
                     <?php echo $form->radio('pTemplateIcon', $ic, $ic == $template->getPageTemplateIcon())?>
                </label>
              </div>
              <?php $i++; ?>
            <?php } ?>
            </div>
        </div>
      
    <div class="ccm-dashboard-form-actions-wrapper">
    <div class="ccm-dashboard-form-actions">
        <a href="<?php echo $view->url('/dashboard/pages/templates')?>" class="btn btn-default pull-left"><?php echo t("Cancel")?></a>
        <div class="btn-toolbar pull-right">
            <button class="btn btn-danger" onclick="deleteTemplate()" type="button"><?php echo t('Delete Template')?></button>
            <button type="submit" class="btn btn-primary"><?php echo t('Update')?></button>
        </div>
    </div>
    </div> 

    </form>
    

<?php } else { ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?php echo View::url('/dashboard/pages/templates/add')?>" class="btn btn-primary"><?php echo t("Add Template")?></a>
    </div>

    <?php if (count($templates) == 0) { ?>
        <br/><strong><?php echo t('No page types found.')?></strong><br/><br>
    <?php } else { ?>

        <table class="table table-striped">

    <?php foreach($templates as $pt) { ?>
        <tr>
            <td><a href="<?php echo $view->action('edit', $pt->getPageTemplateID())?>"><?php echo $pt->getPageTemplateIconImage()?></a></td>
            <td style="width: 100%; vertical-align: middle"><a href="<?php echo $view->action('edit', $pt->getPageTemplateID())?>"><p class="lead" style="margin-bottom: 0px"><?php echo $pt->getPageTemplateDisplayName()?></p></a></td>
        </tr>
    <?php } ?>


        </table>

    <?php } ?>

<?php } ?>