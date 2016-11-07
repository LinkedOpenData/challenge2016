<?php        

namespace Concrete\Package\ResponsiveEmbed;
use Package;
use BlockType;
use SinglePage;
use PageTheme;
use BlockTypeSet;
use CollectionAttributeKey;
use Concrete\Core\Attribute\Type as AttributeType;
use Config;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

	protected $pkgHandle = 'responsive_embed';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0.0';
	
	
	
	public function getPackageDescription()
	{
		return t("Embed external content responsively");
	}

	public function getPackageName()
	{
		return t("Responsive Embed");
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('responsive_embed', $pkg); 
	}
}
?>