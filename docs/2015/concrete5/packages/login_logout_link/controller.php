<?php        

namespace Concrete\Package\LoginLogoutLink;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

	protected $pkgHandle = 'login_logout_link';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0';
	
	
	
	public function getPackageDescription()
	{
		return t("Add a Login/Logout link to your site");
	}

	public function getPackageName()
	{
		return t("Login/Logout Link");
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('login_logout_link', $pkg); 
        
	}
}
?>