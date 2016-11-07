<?php  defined('C5_EXECUTE') or die('Access Denied.');
/**
 *-----------------------------------------------------------------------------*
 *                                                                             *
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2013 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */

$form = \Core::make( 'helper/form');
$ih = \Core::make( 'helper/concrete/ui' );
$uh = \Core::make( 'helper/concrete/urls' );

use Concrete\Package\GntMathjax\Src\MathjaxAsset;


$pkg = Package::getByHandle( 'gnt_mathjax' );
$path = $uh->getPackageURL($pkg);
$baseConf = "$path/config-samples/";

$canUseLocal = $pkg->canUseLocalMathJax();
$options = MathjaxAsset::getAvailableConfigs();

$hide = 'style="display:none"';

$hideLocalWarn  = $useCDN ? $hide : '';
$hideCDNversion = $useCDN ? '' : $hide;
$hideInline     = $configName != MathjaxAsset::CONF_INLINE ? 'display:none' : '';

// Defaulting arguments :

if ( ! $CDNversion ) $CDNversion = 'latest';

/*
 * Retrieve all currently existing templates
 */
$path = $pkg->getPackagePath() . "/config-samples/*.js";
$bases = array();
foreach( glob( $path ) as $fileName )
{
	$file = basename( $fileName );
	$f = pathinfo( $file, PATHINFO_FILENAME );
	if ( array_key_exists( $f, $options ) ) $caption = $options[$f];
	else $caption = t( "Undocumented configuration sample" );
	$bases[$file] = "$file : $caption" ;
}

$list = $options;
unset($list[MathjaxAsset::CONF_INLINE]);
foreach ( $list as $key => $val ) $options[$key] = "$key.js: $val";

?>
<style type="text/css">
	.clearfix { clear: both; }
</style>

<div class="form-group clearfix">
	<?php echo  $form->label('useCDN', t('Use CDN MathJax'), array('class' => 'col-sm-4')  )?>
	<div class="input-group col-sm-8 has-feedback <?php echo !$useCDN?'has-warning':''?>" id="use-cdn-container">
		<span class="input-group-addon">
			<?php  if ( !$canUseLocal )  { ?>
				<?php echo $form->hidden( 'useCDN', 1 ); ?>
				<?php echo $form->checkbox( 'useCDN', 1, 1, array( 'disabled' => 'disabled' ) ); ?>
			<?php  } else { ?>
				<?php echo $form->checkbox( 'useCDN', 1, $useCDN ); ?>
			<?php  } ?>
		</span>
		<?php echo $form->text( 'CDNversion', $CDNversion, $useCDN ? array() : array ( 'disabled' => 'disabled' ) ) ?>
	</div>
	<div class="help-block col-sm-offset-4">
		<span class="text-warning" id="warn-dont-use-cdn" <?php echo $hideLocalWarn?> ><?php echo t("WARNING: Using a local version may increase loading time compared to using CDN")?> </span>
		<span id="cdn-version-help" <?php echo $hideCDNversion?> ><?php echo t("If unsure, keep '%s' here", 'latest' ); ?></span>
	</div>
</div>
<script type="text/javascript">
$("#useCDN").change( function()
	{
		var useCDN = $('#useCDN').is(':checked');
		if (!useCDN)
		{
			$("#warn-dont-use-cdn").show();
			$("#cdn-version-help").hide();
			$('#use-cdn-container').addClass('has-warning')
			$('#CDNversion').enable(false);
		}
		else
		{
			$("#warn-dont-use-cdn").hide();
			$("#cdn-version-help").show();
			$('#use-cdn-container').removeClass('has-warning')
			fixEditorSizes();
			$('#CDNversion').enable(true);
		}
	}
);
</script>

<div class="form-group clearfix">
	<?php echo  $form->label('configName', t('Common config'), array( 'class' => 'col-sm-4') )?>
	<div class="input col-sm-8">
	<?php echo $form->select( 'configName', $options, $configName ); ?>
	<div class="help-block"><?php echo t("Choose the configuration accordingly to your needs, inline lets you enter a specific configuration" ); ?></div>
	</div>
</div>

<script type="text/javascript">
$("#configName").change( function()
	{
		var div = $("#inline-config-wrapper");
		if ( $("#configName").val() == '<?php echo MathjaxAsset::CONF_INLINE?>' ) div.show();
		else div.hide();
	}
);

</script>

<!-- inline configuration, used to create a custom  configuration -->
<div class="panel panel-default" id="inline-config-wrapper" style="clear:both;<?php echo $hideInline?>" >
	<div class="panel-heading" style="text-align:center; font-weight: bold"><?php echo t('Custom Configuration File')?></div>

		<div class="form-group" style="clear:both" id="template_loader">
			<div class="col-sm-10" style="padding:0" ><?php echo $form->select( 'template_base', $bases ); ?></div>
			<div class="col-sm-2'">
				<?php echo  $ih->button_js( t("Apply"), 'applyTemplate()', 'right', null, array( 'id' => 'apply-btn')  ); ?>
			</div>
		</div>
		<div style="clear:both">
			<?php echo $form->textarea( 'inlineConfig', $inlineConfig, array('style'=>'height:100px; display: none')); ?>

			<div id="inlineConfig_editor_wrapper" style="border: 1px solid #ccc; background-color:#eeeeee;height:200px; margin:0; padding=0; padding-bottom:14px; ">
					<div id="inlineConfig_editor" style="height:200px; margin:0px "></div>
			</div>
		</div>

		<script type="text/javascript">
			jsEditor = null;

			function initjsEditor()
			{
				// Instanciate ACE
				jsEditor = ace.edit("inlineConfig_editor");
				jsEditor.setValue( $("#inlineConfig").val() );
				jsEditor.getSession().setMode('ace/mode/javascript');
				jsEditor.setTheme('ace/theme/textmate' );
				jsEditor.clearSelection();
			}

			// Fix layouts
			function fixEditorSizes()
			{
				div = $("#inlineConfig_editor_wrapper");
				ld  = $('#template_loader');
				ld.css({width: div.width()} );
			}

			$(function(){ 
				initjsEditor();

				// Make everything resizable
				$('#inlineConfig_editor_wrapper').resizable(
					{ 
						resize: function(event, ui)
						{
							div = $('#inlineConfig_editor');
							div.css( {width: ui.element.width(), height: ui.element.height()} );
							jsEditor.resize();
							fixEditorSizes();
						}
					}
				);

			});

		</script>

	<div class="panel-footer">
		<?php echo t("configuration must be a valid javascript code, use templates for easy customization. The easiest way to have a working configuration is to start by modifying an existing template")?>
	</div>
</div>

<script type="text/javascript">

function applyTemplate()
{
	var js = $("#template_base").val();
	var url = "<?php echo $baseConf?>" + js;
	$.ajax ( {
		url: url,
		dataType: "text",
		success: function ( d ) 
		{ 
			jsEditor.setValue( d );
			jsEditor.clearSelection();
		},
	});
}

function showUIErrors()
{
    if (ccm_isBlockError) {
        jQuery.fn.dialog.hideLoader();
        if(ccm_blockError) {
            ccmAlert.notice(ccmi18n.error, ccm_blockError + '</ul>');
        }
        ccm_resetBlockErrors();
        return false;
    }
}

// Must call this function upon submit !
function saveEditorValue() { $('#inlineConfig').val( jsEditor.getValue() ); }
</script>

<?php 

// vim: set noexpandtab ts=4 :
