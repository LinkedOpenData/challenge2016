<?php 
namespace Concrete\Package\PdfViewer\Block\PdfViewer;

use \Concrete\Core\Block\BlockController;
use Loader;
class Controller extends BlockController {
	
	protected $btTable = "btPdfViewer";
	protected $btInterfaceWidth = "370";
	protected $btInterfaceHeight = "400";

	public function getBlockTypeName() {
		return t('PDF Viewer');
	}

	public function getBlockTypeDescription() {
		return t('Block for viewing PDF Files');
	}
	
	public function validate($args) {
        $e = Loader::helper('validation/error');
        if ($args['pdf_file'] < 1 && !$args["external_url"]) {
            $e->add(t('You must select a file.'));
        }
        if($args["external_url"]){
            if(filter_var($args["external_url"], FILTER_VALIDATE_URL) === FALSE){
                $e->add(t('External URL needs to be a valid URL'));
            }
        }
        if(!$args["width"] || !$args["height"]){
        	$e->add(t('Width/height cannot be empty'));
        }else{
        	if(!is_numeric($args["width"]) || !is_numeric($args["height"])){
        		$e->add(t('Width/height must be a number'));
        	}
        	if(strlen($args["width"]) >= 5 || strlen($args["height"]) >= 5){
        		$e->add(t('Width/height too long!'));
        	}
            if($args["width"] <= 0 || $args["height"] <= 0){
                $e->add(t("Width/height must be > 0"));
            }
        }

        if($args[external_url] && $args["pdf_file"]){
            $e->add(t('You can not select file AND external URL.'));
        }
        return $e;
    }
}
