<?php          
namespace Concrete\Package\HwBackToTop\Block\BackToTop;
use Package;
use View;
use Loader;
use Page;
use Core;
use \Concrete\Core\Block\BlockController;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController {
	

	public function getBlockTypeDescription()
    {
        return t("Adds a Back to Top on your website page.");
    }

    public function getBlockTypeName()
    {
        return t("HW Back To Top");
    }
		public function registerViewAssets()
    {
		$pkg = Package::getByHandle('hw_back_to_top');    
        $packagePath = $pkg->getRelativePath();
		$this->addFooterItem(Core::make('helper/html')->javascript($packagePath.'/js/back-to-top.js','hw_back_to_top'));
        $this->addHeaderItem(Core::make('helper/html')->css($packagePath.'/css/back-to-top.css','hw_back_to_top'));    
    }


}
?>