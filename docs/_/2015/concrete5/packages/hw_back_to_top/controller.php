<?php      
namespace Concrete\Package\HwBackToTop;
use Package;
use BlockType;
use View;
use Loader;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package {

	protected $pkgHandle = 'hw_back_to_top';
	protected $appVersionRequired = '5.7.4';
	protected $pkgVersion = '0.9.4';
			
 	
	public function getPackageName() 
	{
		return t("Honest Websites Back To Top");
	}

	public function getPackageDescription() 
	{
		return t("Add an back to top icon on your web page");
	}

	public function install() 
	{
		$pkg = parent::install();

		// install block
		BlockType::installBlockTypeFromPackage('back_to_top', $pkg);
		
		return $pkg;
	}
	public function uninstall() {
		parent::uninstall();
	}

}