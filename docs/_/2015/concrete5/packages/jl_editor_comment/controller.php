<?php  
namespace Concrete\Package\JlEditorComment;
use Package;
use BlockType;
use Concrete\Core\Block\BlockType\Set;
use Loader;

defined('C5_EXECUTE') or die("Access Denied.");

/*
Editor Comment by John Liddiard (aka JohntheFish)
www.c5magic.co.uk
This software is licensed under the terms described in the concrete5.org marketplace.
Please find the add-on there for the latest license copy.
*/

class Controller extends Package {

	protected $pkgHandle = 'jl_editor_comment';
	protected $appVersionRequired = '5.7.0.4';
	protected $pkgVersion = '7.0.1';


	public function getPackageName() {
		return t('Editor Comment');
	}

	public function getPackageDescription() {
		return t('Enter a comment that shows only in edit mode. For use by site developers who want to leave notes/comments for those editing a page in the future.');
	}

	public function install() {
		$pkg = parent::install();
		self::install_or_upgrade($pkg);
	}

	public function upgrade() {
 		parent::upgrade();
		self::install_or_upgrade($this);
	}

	/*
	Clean up on uninstall
	*/
	public function uninstall() {

		$btobj = BlockType::getByHandle('jl_editor_comment');
		if(is_object($btobj)){
			$btID = $btobj->getBlockTypeID();
		}

		parent::uninstall();
		$db = Loader::db();



		$db->Execute('DROP TABLE IF EXISTS btJlEditorComment');
		
		/*
		Also remove the block type set from the global space
		if no-one else is using it.
		*/
		$dev_set = Set::getByHandle('developer');
		if(is_object($dev_set) && !empty($btID)){
		
			/*
			Need to enquire directly rather than Set API because:
			- core doesn't seem to process block removal before the API call is made
			- We don't need to instantiate all the block types, just count them
			
			Ideally we could do with a count method in the Set API.
			*/
			$num_bts_in_set = $db->GetOne('SELECT COUNT(*) FROM BlockTypeSetBlockTypes WHERE btsID = ? AND btID <> ?', array($dev_set->getBlockTypeSetID(), $btID));
			if(empty($num_bts_in_set)){
				$dev_set->delete();
			}
		}
	}


	private static function install_or_upgrade($me){
 		
 		/*
 		We need the set before installing the block.
 		Its in the global space so others can use it.
 		It gets cleared up on uninstall if nothing is 
 		left in it.
 		*/
 		if(!is_object(Set::getByHandle('developer'))){
 			Set::add('developer', t('Developer'));
 		}

		// install block
 		if(!is_object(BlockType::getByHandle('jl_editor_comment'))){
			BlockType::installBlockTypeFromPackage('jl_editor_comment', $me);
 		}
 		
 		
	}

}