<?php    

namespace Concrete\Package\WebinstinctColorpickerAttribute;
use Package;
use BlockType;
use SinglePage;
use Loader;
use Config;
use Concrete\Core\Attribute\Type as AttributeType;
use Concrete\Core\Attribute\Key\Category  as AttributeKeyCategory;
use Concrete\Core\Attribute\Key\Key as AttributeKey;


defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package {

	protected $pkgHandle = 'webinstinct_colorpicker_attribute';
	protected $appVersionRequired = '5.7.0.4';
	protected $pkgVersion = '0.4';
	
	public function getPackageDescription() {
		return t('Add a colorpicker attribute to your site');
	}
	
	public function getPackageName() {
		return t('Colorpicker Attribute');
	}

    public function on_start() {
    }
    
	public function install() {
		$pkg = parent::install();
        $type = AttributeType::add("colorpicker","Colorpicker",$pkg);
        
        // associate this attribute type with all category keys
		$cKey = AttributeKeyCategory::getByHandle('collection');
		$cKey->associateAttributeKeyType($type);
	}
	
	public function upgrade(){
		parent::upgrade(); 
	}

	public function uninstall(){
	   $db = Loader::db();
       
        // remove the attribute
        $at = AttributeType::getByHandle('colorpicker');
        
        // loop through all AttributeKeys of this AttributeType
        $r = $db->Execute("SELECT akID FROM AttributeKeys WHERE atID=?",array($at->getAttributeTypeID()));
        while ($row = $r->FetchRow()) {            
            // delete the CollectionAttributeValues
            $db->Execute("DELETE FROM CollectionAttributeValues WHERE akID=?",array($row['akID'])); 
            $db->Execute("DELETE FROM AttributeKeys WHERE akID=?",array($row['akID'])); 
        }                

        $at->delete();
        
        // remove the table
        $db = Loader::db();
        $db->Execute("DROP TABLE IF EXISTS atColorpicker;");
        

        $pkg = parent::uninstall();
  	}
}
?>