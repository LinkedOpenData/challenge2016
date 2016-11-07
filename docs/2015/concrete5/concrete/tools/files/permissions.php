<?php
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\File\EditResponse as FileEditResponse;
use \Concrete\Core\File\StorageLocation\StorageLocation as FileStorageLocation;

$u = new User();
$form = Loader::helper('form');
$ih = Loader::helper('concrete/ui'); 
$f = File::getByID($_REQUEST['fID']);
$cp = new Permissions($f);
if (!$cp->canAdmin()) {
	die(t("Access Denied."));
}
$form = Loader::helper('form');

$r = new FileEditResponse();
$r->setFile($f);

if ($_POST['task'] == 'set_password') {
	$f->setPassword($_POST['fPassword']);
	$r->setMessage(t('File password saved successfully.'));
	$r->outputJSON();
}



if ($_POST['task'] == 'set_location') {
    $fsl = FileStorageLocation::getByID($_POST['fslID']);
    if (is_object($fsl)) {
        try {
            $f->setFileStorageLocation($fsl);
        } catch(\Exception $e) {
            $json = new \Concrete\Core\Application\EditResponse;
            $err = new \Concrete\Core\Error\Error;
            $err->add($e->getMessage());
            $json->setError($err);
            $json->outputJSON();
        }
    }
	$r->setMessage(t('File storage location saved successfully.'));
	$r->outputJSON();

}

?>

<div class="ccm-ui" id="ccm-file-permissions-dialog-wrapper">

<ul class="nav nav-tabs" id="ccm-file-permissions-tabs">
	<?php if (Config::get('concrete.permissions.model') != 'simple') { ?>
		<li class="active"><a href="javascript:void(0)" id="ccm-file-permissions-advanced"><?php echo t('Permissions')?></a></li>
	<?php } ?>
	<li <?php if (Config::get('concrete.permissions.model') == 'simple') { ?> class="active" <?php } ?>><a href="javascript:void(0)" id="ccm-file-password"><?php echo t('Protect with Password')?></a></li>
	<li><a href="javascript:void(0)" id="ccm-file-storage"><?php echo t('Storage Location')?></a></li>
</ul>

<div class="clearfix"></div>

<?php if (Config::get('concrete.permissions.model') != 'simple') { ?>

<div id="ccm-file-permissions-advanced-tab">

	<?php Loader::element('permission/lists/file', array('f' => $f)); ?>

</div>
<?php } ?>

<div id="ccm-file-password-tab" <?php if (Config::get('concrete.permissions.model') != 'simple') { ?> style="display: none" <?php } ?>>
<br/>

<h4><?php echo t('Requires Password to Access')?></h4>

<p><?php echo t('Leave the following form field blank in order to allow everyone to download this file.')?></p>

<form method="post" data-dialog-form="file-password" action="<?php echo Loader::helper('concrete/urls')->getToolsURL('files/permissions')?>">
<?php echo $form->hidden('task', 'set_password')?>
<?php echo $form->hidden('fID', $f->getFileID())?>
<?php echo $form->text('fPassword', $f->getPassword(), array('style' => 'width: 250px'))?>

<div id="ccm-file-password-buttons"  style="display: none">
	<button type="button" onclick="jQuery.fn.dialog.closeTop()" class="btn btn-default pull-left"><?php echo t('Cancel')?></button>
	<button type="button" onclick="$('form[data-dialog-form=file-password]').submit()" class="btn btn-primary pull-right"><?php echo t('Save Password')?></i></button>
</div>

</form>

<div class="help-block"><p><?php echo t('Users who access files through the file manager will not be prompted for a password.')?></p></div>

</div>

<div id="ccm-file-storage-tab" style="display: none">

<br/>

<h4><?php echo t('Choose File Storage Location')?></h4>

<form method="post" data-dialog-form="file-storage" action="<?php echo Loader::helper('concrete/urls')->getToolsURL('files/permissions')?>">
<div class="help-block"><p><?php echo t('All versions of a file will be moved to the selected location.')?></p></div>

<?php echo $form->hidden('task', 'set_location')?>
<?php echo $form->hidden('fID', $f->getFileID())?>
<?php
$locations = FileStorageLocation::getList();
foreach($locations as $fsl) { ?>
    <div class="radio"><label><?php echo $form->radio('fslID', $fsl->getID(), $f->getStorageLocationID() == $fsl->getID()) ?> <?php echo $fsl->getDisplayName()?></label></div>
<?php } ?>
</form>

<div id="ccm-file-storage-buttons" style="display: none">
	<button type="button" onclick="jQuery.fn.dialog.closeTop()" class="btn btn-default pull-left"><?php echo t('Cancel')?></button>
	<button type="button" onclick="$('form[data-dialog-form=file-storage]').submit()" class="btn btn-primary pull-right"><?php echo t('Save Location')?></i></button>

</div>



</div>

</div>

<script type="text/javascript">
	
$("#ccm-file-permissions-tabs a").click(function() {
	$("li.active").removeClass('active');
	$("#" + ccm_fpActiveTab + "-tab").hide();
	ccm_fpActiveTab = $(this).attr('id');
	$(this).parent().addClass("active");
	$("#" + ccm_fpActiveTab + "-tab").show();
	ccm_filePermissionsSetupButtons();
});

ccm_filePermissionsSetupButtons = function() {
	var $dialog = $("#ccm-file-permissions-dialog-wrapper").closest('.ui-dialog-content');
	if ($("#" + ccm_fpActiveTab + "-buttons").length > 0) {
		$dialog.jqdialog('option', 'buttons', [{}]);
		$dialog.parent().find(".ui-dialog-buttonset").remove();
		$dialog.parent().find(".ui-dialog-buttonpane").html('');
		$("#" + ccm_fpActiveTab + "-buttons").clone().show().appendTo($dialog.parent().find('.ui-dialog-buttonpane').addClass('ccm-ui'));
	} else {
		$("#ccm-file-permissions-dialog-wrapper").closest('.ui-dialog-content').jqdialog('option', 'buttons', false);
	}

}

var ccm_fpActiveTab;

$(function() {
<?php if (Config::get('concrete.permissions.model') == 'simple') { ?>
	ccm_fpActiveTab = "ccm-file-password";
<?php } else { ?>
	ccm_fpActiveTab = "ccm-file-permissions-advanced";
<?php } ?>

	ccm_filePermissionsSetupButtons();
	//$('form[data-dialog-form=file-storage],form[data-dialog-form=file-password]').concreteAjaxForm();
});
	
</script>
