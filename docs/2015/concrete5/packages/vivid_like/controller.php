<?php       

namespace Concrete\Package\VividLike;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

	protected $pkgHandle = 'vivid_like';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '0.9.1';
	
	
	
	public function getPackageDescription()
	{
		return t("Add Facebooks Like Button to your site");
	}

	public function getPackageName()
	{
		return t("Like This");
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('likethis', $pkg); 
        
	}
}
?>