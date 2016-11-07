<?php  
namespace Concrete\Package\JlEditorComment\Block\JlEditorComment;

use Concrete\Core\Block\BlockController;
use Loader;
use Package;
use User;
use Page;
use Config;


defined('C5_EXECUTE') or die("Access Denied.");

/*
Editor Comment by John Liddiard (aka JohntheFish)
www.c5magic.co.uk
This software is licensed under the terms described in the concrete5.org marketplace.
Please find the add-on there for the latest license copy.
*/

class Controller extends BlockController {

	protected $btTable = 'btJlEditorComment';
	protected $btInterfaceWidth = "500";
	protected $btInterfaceHeight = "375";

	/*
	Any sort of caching can mess up the display, so turn it all off
	and also have mechanisms to not show (css) and clean up (javascript)
	*/
	protected $btCacheBlockRecord = false;
	protected $btCacheBlockOutput = false;
	protected $btCacheBlockOutputOnPost = false;
	protected $btCacheBlockOutputForRegisteredUsers = false;

	/*
	Removes all grid framework elements in view.
	http://www.concrete5.org/profile/messages/-/view_message/inbox/612935/
	http://www.concrete5.org/profile/messages/-/view_message/inbox/614147/
	*/
	protected $btIgnorePageThemeGridFrameworkContainer = true;


	/*
	Upgrade to inline editing
	http://www.concrete5.org/community/forums/5-7-discussion/a-table-block-asset-registering-and-inline-block-editing/
	http://www.mesuva.com.au/blog/concrete5/a-table-block-for-concrete5-57-with-inline-editing-and-asset-registering/
	https://github.com/Mesuva/msv_table
	*/
	protected $btSupportsInlineEdit = true;
	protected $btSupportsInlineAdd = true;


	public function getBlockTypeName() {
		$pkg  = Package::getByHandle('jl_editor_comment');
		return $pkg->getPackageName();
	}

	public function getBlockTypeDescription() {
		$pkg  = Package::getByHandle('jl_editor_comment');
		return $pkg->getPackageDescription();
	}

	public function getBlockTypeHelp() {
		return $this->getBlockTypeDescription();
	}

	/*
	The set 'developer' has been added by the package controller
	*/
	public function getBlockTypeDefaultSet() {
		return 'developer';
	}

	/*
	Is there a better way to add styles directly via the c5.7 asset system?
	*/	
	public function on_page_view() {
		
		if ($this->show_comment()) {
			$this->addHeaderItem($this->comment_styles());
		}else{
			// included just in case caching messes up between edit mode and view
			$this->addHeaderItem($this->no_comment_styles());
		}
	}

	public function save($data){
		$u = new User();
		$uID = $u->getUserID();
		$data['by_uID'] = $uID;
		$data['comment_text'] = strip_tags($data['comment_text']);
		parent::save($data);
	}


	public function view(){
		// erase if we don't want it shown
		if (!$this->show_comment()){
			$this->set('comment_text', '');
		} else {
			$this->set('comment_text', $this->comment_text);
			
			/*
			Optional custom date format
			*/	
			$date_format = Config::get('app.editor_comment.date_format');
			if(!empty($date_format)){
				$tc = strtotime($this->timestamp);
				$ftc = date(t($date_format), $tc);
				$this->set('timestamp', $ftc);						
			} else {
				$this->set('timestamp', $this->timestamp);			
			}
			
			$by_user = User::getByUserID($this->by_uID);
			if(!empty($by_user) && is_object($by_user)){
				$this->set('by_user', $by_user->getUserName());
			} else {
				$this->set('by_user', t('Unknown User'));			
			}
		}	
	}

	
	/*
	Decides if a comment should be shown
	*/	
	public function show_comment(){
		
		/*
		Can show comments on all pages by setting app.editor_comment.developer_view = true.
		*/
		if( Config::get('app.editor_comment.developer_view') ){
			return true;
		}
		
		$page = Page ::getCurrentPage();
		
		if(!is_object($page)){
			return false;
		}
		
		if ($page->isEditMode()){
			return true;
		}
		/*
		Maybe also show in dashboard - when viewing stacks etc.
		http://www.concrete5.org/documentation/how-tos/designers/check-if-block-is-being-displayed-in-the-stack-dashboard-edit-pa/
		*/
		if ($page->isAdminArea()){
			return true;		
		}
		$path = $page->getCollectionPath();
		if (strpos($path, '/dashboard/blocks/stacks/view_details/')) {
			return true;
		}
		if (strpos($path, '!stacks')) {
			return true;
		}
		
		/*
		No reason to show, so the default is false!!!
		*/
		return false;
	}


	/*
	The comment styles are split up so they can be inserted in different places and different ways.
	
	The no_comment styles are inserted when not in edit mode. This is not strictly needed, but is 
	a safety measure in case eager c5 caching leaves the edit mode comments in place!
	*/
	
	public function comment_styles (){
		return '<style>.jl_editor_comment{'.$this->raw_comment_styles().'padding:35px 10px 10px 10px;position:relative;}</style>';
	}


	public function raw_comment_styles (){
		
		/*
		The comment text and background colors can be set sitewide through these constants
		*/
		$editor_comment_text_color = Config::get('app.editor_comment.text_color');
		$editor_comment_background_color = Config::get('app.editor_comment.background_color');
		
		if (empty($editor_comment_text_color)){
			$editor_comment_text_color = '#101010';
		}
		if (empty($editor_comment_background_color)){
			$editor_comment_background_color = '#fff79d';
		}
	
		return 'background-color:'.$editor_comment_background_color.';color:'.$editor_comment_text_color.';';
	}


	public function no_comment_styles (){
		return '<style>.jl_editor_comment{display:none;}</style>';
	}


}