<?php 
namespace Concrete\Package\Zoomer\Block\Zoomer;
use \Concrete\Core\Block\BlockController;
use Loader;
use \File;
use \Concrete\Core\Block\View\BlockView as BlockView;
use Core;

class Controller extends BlockController
{
    protected $btTable = 'btZoomer';
    protected $btInterfaceWidth = "600";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "465";

    public function getBlockTypeDescription()
    {
        return t("Add Zoomable Images");
    }

    public function getBlockTypeName()
    {
        return t("Zoomer");
    }
    public function registerViewAssets()
    {
    	$uh = Loader::helper('concrete/urls');
		$bObj = $this->getBlockObject();
		if($bObj){
			$bt=$bObj->getBlockTypeObject();
			$blockURL = $uh->getBlockTypeAssetsURL($bt);
			$this->requireAsset('javascript', 'jquery');
			if($this->zoomType=="lightbox"){
				$this->addHeaderItem('<link rel="stylesheet" type="text/css" href="'.$blockURL.'/assets/featherlight.css"/>');
				$this->addFooterItem('<script type="text/javascript" src="'.$blockURL.'/assets/featherlight.js"></script>');
			}
			else{
				$this->addFooterItem('<script type="text/javascript" src="'.$blockURL.'/assets/elevateZoom.js"></script>');
			}
		}
    }
    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if(empty($args['fID'])){
            $e->add(t('You need to select an image'));
        }
        if(empty($args['maxThumbWidth'])){
            $e->add(t("Max Thumbnail Width must be set"));
        }
        if(!ctype_digit(trim($args['maxThumbWidth']))){
            $e->add(t("Max Thumbnail Width must be solely numeric"));
        }
        if(empty($args['maxThumbHeight'])){
            $e->add(t("Max Thumbnail Height must be set"));
        }
        if(!ctype_digit(trim($args['maxThumbHeight']))){
            $e->add(t("Max Thumbnail Height must be solely numeric"));
        }
        if(empty($args['maxImageWidth'])){
            $e->add(t("Max Image Width must be set"));
        }
        if(!ctype_digit(trim($args['maxImageWidth']))){
            $e->add(t("Max Image Width must be solely numeric"));
        }
        if(empty($args['maxImageHeight'])){
            $e->add(t("Max Image Height must be set"));
        }
        if(!ctype_digit(trim($args['maxImageHeight']))){
            $e->add(t("Max Image Height must be solely numeric"));
        }
        return $e;
    }
}