<?php       

namespace Concrete\Package\Zoomer;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

	protected $pkgHandle = 'zoomer';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0.1';
	
	
	
	public function getPackageDescription()
	{
		return t("Add Zoomable Images to your site");
	}

	public function getPackageName()
	{
		return t("Zoomer");
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('zoomer', $pkg); 
        
	}
}
?>