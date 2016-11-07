<?php  
namespace Concrete\Package\GntMathjax\Block\GntMathjax;
defined('C5_EXECUTE') or die('Access Denied.');

/**
 *-----------------------------------------------------------------------------*
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2014 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */

use Concrete\Core\Block\BlockController;
use Concrete\Package\GntMathjax\Src\MathjaxAsset;
use Page;

class Controller extends BlockController
{

	protected $btTable = "btGntMathJax";
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "600";

	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = true;

	protected $btDefaultSet 						= 'basic';

	public function getBlockTypeDescription() { return t('Adds MathJax to the page.'); }
	public function getBlockTypeName()        { return t('MathJax'); }

	public function on_page_view()
	{
		// First check that the current page does not have the mathjax attribute
		// We don't want to collide with ourself, do we
		$page = Page::getCurrentPage();
		if ( !$page || $page->isError() ) return;
		if ( $page->getCollectionAttributeValue('load_mathjax') ) return;

		$mathjax = MathjaxAsset::instance();

		if ( ! $this->useGlobalConf )
		{
			$mathjax->setUseCDN( $this->useCDN );
			$mathjax->setCDNVersion( $this->CDNversion );
			$mathjax->setConfigName( $this->configName );
			$mathjax->setInlineConf( $this->inlineConfig );
		}

		$this->requireAsset( MathjaxAsset::$handle );
	}

	public function save( $args )
	{
		$args['useGlobalConf'] = ( '' == $this->post('useGlobalConf') || 0 == $this->post('useGlobalConf') ) ? 0 : 1;
		$args['useCDN'] = ( '' == $this->post('useCDN') || 0 == $this->post('useCDN') ) ? 0 : 1;
		parent::save( $args );
	}

	public function add() { $this->edit(); }
	public function edit()
	{
		$this->requireAsset('ace');
	}
}

// vim: set noexpandtab ts=4 :
