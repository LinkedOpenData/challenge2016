<?php  defined('C5_EXECUTE') or die('Access Denied.');
/**
 *-----------------------------------------------------------------------------*
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2013 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */


$hideCustom = $useGlobalConf ? 'style="display:none"' : '';

?>

<div class="">
	<?php echo  $form->label('useGlobalConf', t('Use Global Config'), array( 'class' => 'col-sm-4')   )?>
	<div class="input col-sm-8">
	<?php echo $form->checkbox( 'useGlobalConf', 1, $useGlobalConf); ?>
	</div>
</div>

<script type="text/javascript">
$("#useGlobalConf").change( function()
{
    $("#mathjax-custom-config").toggle();
}
);
</script>

<div id="mathjax-custom-config" <?php echo $hideCustom?> >
<?php  View::packageElement( 'edit_ajax_options', 'gnt_mathjax', get_defined_vars() ); ?>
</div>

<script type="text/javascript">

$('#ccm-form-submit-button').click(function(e){ saveEditorValue(); } );
</script>

