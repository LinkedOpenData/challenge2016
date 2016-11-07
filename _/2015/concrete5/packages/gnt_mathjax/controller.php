<?php  
namespace Concrete\Package\GntMathjax;
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

use Package;
use Config;
use Page;
use BlockType;
use SinglePage;
use Events;
use Database;
use View;
use Log;
use \Concrete\Core\Attribute\Type as AttributeType;
use \Concrete\Core\Attribute\Key\CollectionKey as CollectionAttributeKey;

use Concrete\Core\Routing\Router;
use Concrete\Core\Support\Facade\Route;

use Concrete\Package\GntMathjax\Src\MathjaxAsset;

class Controller extends Package 
{

	protected $pkgHandle = 'gnt_mathjax';
	protected $appVersionRequired = '5.7.0.4';
	protected $pkgVersion = "2.0.3";

	public function getPackageDescription() { return t("Use MathJax display pretty mathematics (using TeX/MathML/MathASCII syntax)"); }
	public function getPackageName() 		{ return t("Load MathJax"); }

	public function install()
	{
		$pkg = parent::install();
		BlockType::installBlockTypeFromPackage('gnt_mathjax', $pkg ); 

		// Create the mathjax attribute :
		$key = CollectionAttributeKey::getByHandle('load_mathjax');

		// Check that our attribute is not already there :
		if ( !$key || !intval( $key->getAttributeKeyID() ) )
		{
			$bool = AttributeType::getByHandle('boolean');
			$desc =	array ( 'akHandle' => 'load_mathjax', 'akName'=> t('Load MathJax'), 'akIsSearchable' => false );
			$key = CollectionAttributeKey::add(	$bool, $desc );
		}

        $co = $this->getConfig();

		$co->save("cdn.enable", 1 );
		$co->save("cdn.version", 'latest' );
		$co->save("template.default", "TeX-AMS-MML_HTMLorMML-full" );
		$co->save("template.inline", "" );

		// Install the global configuration dashboard page :

		$dash = SinglePage::add('/dashboard/system/environment/mathjax', $pkg);
		$dash->update(array('cName' => t('MathJax Settings'), 'cDescription' => t('MathJax global configuration (paths, options, configuration)')));
	}

	public function canUseLocalMathJax()
	{
		$filename = $this->getPackagePath() . "$path/js/mathjax/MathJax.js";
		return file_exists( $filename );
	}

	public function getCDNVersion() { return $this->getConfig()->get('cdn.version'); }
	public function setCDNVersion( $ver ) { return $this->getConfig()->save('cdn.version', $ver ); }

	public function useCDN() { return $this->getConfig()->get( 'cdn.enable' ) != 0; }
	public function setUseCDN( $use ) { $this->getConfig()->save( 'cdn.enable', ( $use != 0 && $use != '' ) ? 1 : 0 ); }

	public function useCommonConf()
	{ 
		$conf = $this->getDefaultConf();
		return MathjaxAsset::isCommonConf( $conf );
	}

	public function getDefaultConf() 		{ return $this->getConfig()->get('template.default' ); }
	public function setDefaultConf( $name ) { $this->getConfig()->save( 'template.default', $name ); }

	public function getInlineConf() { return $this->getConfig()->get('template.inline' ); }
	public function setInlineConf( $conf ) { $this->getConfig()->save( 'template.inline', $conf ); }


	/*
	 * Make sure we have a chance to add the JS loader in case the page has 
	 * the mathjax attribute :
	 */
	public function on_start() {
		// must use on_before_render event at the package level :
		\Events::addListener( 'on_before_render', array( $this, 'on_before_render' ) );

		Route::register( Router::route( array( '/ajax/edit_ajax_options', 'gnt_mathjax') ), '\Concrete\Package\GntMathjax\Controller\Ajax\EditAjaxOptions::view',    "GntMathjaxEditAjaxOptions" );

		MathjaxAsset::registerGlobalAsset();
	}

	/*
	 * Check that the current page has the gnt_mathjax attribute
	 * activate MathJax if so. (Use the library)
	 */
	public function on_before_render( $event )
	{
		$page = Page::getCurrentPage();
		if ( $page && !$page->isError() && $page->getCollectionAttributeValue('load_mathjax') )
		{
			\View::getInstance()->requireAsset( MathjaxAsset::$handle );
		}
	}


	public function uninstall()
	{
		parent::uninstall();

		$db = Database::getActiveConnection();
		$db->Execute( 'DROP TABLE IF EXISTS btGntMathJax' );
	}
}

// vim: set noexpandtab ts=4 :
