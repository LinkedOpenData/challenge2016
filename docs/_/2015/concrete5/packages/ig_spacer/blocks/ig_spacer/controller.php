<?php      
namespace Concrete\Package\IgSpacer\Block\IgSpacer;
use \Concrete\Core\Block\BlockController;
defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController {
	protected $btTable = 'btIgSpacer';
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "200"; 

	public function getBlockTypeDescription() {
		return t("Add spacer between blocks without coding.");
	}
		
	public function getBlockTypeName() {
		return t("Spacer");
	}
	
	function save($data) { 
		$args['spacerHeight'] = isset($data['spacerHeight']) ? str_replace(' ', '', $data['spacerHeight']) : '0';
		parent::save($args);
	}		
	
	public function delete() {
		parent::delete();
	}
}