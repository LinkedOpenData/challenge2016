<?php   defined('C5_EXECUTE') or die("Access Denied.");
if($pdf_file){
	$link_url = View::url('/download_file', $pdf_file, Page::getCurrentPage()->getCollectionID());
}else {
	$link_url = $external_url;
}
?>
<object style='width:<?php  echo $width.$width_size; ?>; height:<?php  echo $height.$height_size; ?>' type="application/pdf" data="<?php  echo $link_url;?>?#zoom=85&scrollbar=0&toolbar=0&navpanes=0" id="pdf_content">
	<p><?php  echo t('Sorry, the PDF could not be displayed.');?> <a href="<?php  echo $link_url;?>" target="_blank"><?php  echo t('Click here to download the PDF'); ?></a></p>
</object>
