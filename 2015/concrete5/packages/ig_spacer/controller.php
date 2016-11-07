<?php        
namespace Concrete\Package\IgSpacer;
use Package;
use BlockType;
defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package {

	protected $pkgHandle = 'ig_spacer';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '0.9.2';
	
	public function getPackageDescription() {
		return t('Adds space between blocks without coding. More addons and themes <a href="http://www.devphp.net/" target="_blank">www.devphp.net</a>');
	}
	
	public function getPackageName() {
		return t("Spacer");
	}
	
	public function install() {
		$pkg = parent::install();
		BlockType::installBlockTypeFromPackage('ig_spacer', $pkg);
	}

}