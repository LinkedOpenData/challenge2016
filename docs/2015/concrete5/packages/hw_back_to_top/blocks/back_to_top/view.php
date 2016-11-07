<?php       defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php         
$c = Page::getCurrentPage();
if (!$c->isEditMode()) { 
?>
	<a href="#" class="hw-back-to-top">
		<i class="fa fa-chevron-up"></i>
	</a>
<?php  } else {?>
	 <div class="ccm-edit-mode-disabled-item" style="padding: 10px 0px 0px 0px"><?php  echo t('HW Back to top disabled in edit mode.')?></div>
	 <?php  } ?>