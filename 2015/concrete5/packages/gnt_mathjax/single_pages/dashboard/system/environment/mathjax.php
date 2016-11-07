<?php  defined('C5_EXECUTE') or die("Access Denied.");
/**
 *-----------------------------------------------------------------------------*
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright 2014 Florian Delizy <florian.delizy@gmail.com>                    *
 *-----------------------------------------------------------------------------*
 */


$action = $this->action('save_global_settings');
$ui   = \Core::make('helper/concrete/ui');


?>

<form id="mathjax-global-settings" method="post" action="<?php echo $action?>">
    <fieldset>

        <div class="ccm-pane-body">

        <?php  
            $errors->output();
            View::packageElement( 'edit_ajax_options', 'gnt_mathjax', get_defined_vars() );
        ?>
        
        </div>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <?php echo  $ui->submit(t('Save'), 'save','right','btn-primary'); ?>
            </div>
        </div>

    </fieldset>
</form>
<script type="text/javascript">
$("form#mathjax-global-settings").submit( function(){ saveEditorValue(); }); 
</script>
