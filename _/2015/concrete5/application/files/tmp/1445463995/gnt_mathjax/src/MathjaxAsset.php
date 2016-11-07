<?php  
namespace Concrete\Package\GntMathjax\Src;

defined('C5_EXECUTE') or die('Access Denied.');
/**
 *-----------------------------------------------------------------------------*
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2013 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */

use Package;
use AssetList;

use \Concrete\Core\Asset\Asset;
use \Concrete\Core\Asset\JavascriptAsset;

class MathjaxAsset extends JavascriptAsset
{

	protected static $_instance = null;
	public static $handle = 'mathjax';

	public static function instance()
	{
		if ( !self::$_instance ) self::$_instance = new static();
		return self::$_instance;
	}

	const CONF_INLINE	= 'Gnt-MathJAX-Inline-Conf';

	public static function getAvailableConfigs ()
	{
		static $conf = null;

		if (!$conf) 
		{
			$conf = array (
				'TeX-MML-AM_HTMLorMML' 		=> t( "TeX/MathML/AsciiMath format, HTML-CSS/NativeMML, AMSmath, AMSsymbols [Menu,Zoom]" ),
				'TeX-MML-AM_HTMLorMML-full' => t( "TeX/MathML/AsciiMath format, HTML-CSS/NativeMML, AMSmath, AMSsymbols [Menu,Zoom+jax]" ),
				'TeX-AMS-MML_HTMLorMML' 	=> t( 'TeX/MathML format, HTML-CSS/NativeMML, AMSmath, AMSSymbols [Menu,Zoom]' ),
				'TeX-AMS_HTML' 				=> t( 'TeX format, HTML-CSS, AMSmath, AMSsymbols [Menu,Zoom]' ),
				'TeX-AMS_HTML-full' 		=> t( 'TeX format, HTML-CSS, AMSmath, AMSsymbols [Menu,Zoom+jax]' ),
				'MML_HTMLorMML' 			=> t( 'MathML format, NativeMML [Menu,Zoom]' ),
				'MML_HTMLorMML-full' 		=> t( 'MathML format, HTML-CSS/NativeMML [Menu,Zoom+jax]' ),
				'AM_HTMLorMML' 				=> t( 'AsciiMath format, HTML-CSS [Menu,Zoom]' ),
				'AM_HTMLorMML-full' 		=> t( 'AsciiMath format, HTML-CSS [Menu,Zoom-jax]' ),
				'TeX-AMS-MML_SVG' 			=> t( "TeX/MathML/AsciiMath format, SVG, AMSmath, AMSsymbols [Menu,Zoom]" ),
				'TeX-AMS-MML_SVG-full' 		=> t( "TeX/MathML/AsciiMath format, SVG, AMSmath, AMSsymbols [Menu,Zoom+jax]" ),
				'default' 					=> t( "Default configuration (hold all possible values)" ),
				self::CONF_INLINE 			=> t( "Inline Custom Configuration WARNING: Advanced users only !" ),
			);
		}
		return $conf;
	}

	private $_useCDN = true;
	private $_inlineConf;
	private $_configName;
	private $_CDNver;

	// Init an output, initializes all vars from the package config
	// This asset is a singleton please use ::instance()
	public function __construct()
	{
		parent::__construct( self::$handle );

		$pkg = Package::getByHandle( 'gnt_mathjax' );

		$this->_configName = $pkg->getDefaultConf();
		$remote = $this->_useCDN = $pkg->useCDN();
		$this->_CDNver = $pkg->getCDNVersion();
		$this->_inlineConf = $pkg->getInlineConf();

		$this->setPackageObject( $pkg );
		# $this->setAssetVersion( "latest" ); # XXX mandatory?

		$this->setAssetIsLocal( !$remote );
		$this->setAssetPosition( Asset::ASSET_POSITION_HEADER );
	}

    public function assetSupportsMinification() { return false; }
    public function assetSupportsCombination()  { return false; }

	public static function isCommonConf( $confName ) 
	{
		if ( $confName == self::CONF_INLINE ) return false;
		return true;
	}

	public function useCommonConf() 		 { return self::isCommonConf( $this->_configName ); }
	public function setUseCDN( $use = true ) { $this->_useCDN = $use; $this->setAssetIsLocal(!$use); }
	public function useCDN() 			     { return $this->_useCDN; }
	public function getCDNVersion() 		 { return $this->_CDNver; }
	public function setCDNVersion($ver) 	 { $this->_CDNver = $ver; }
	public function setConfigName( $name )   { $this->_configName = $name; }
	public function getConfigName() 		 { return $this->useCommonConf() ? $this->_configName : ''; }
	public function setInlineConf( $conf )   { $this->_inlineConf = $conf; }
	public function getInlineConf()			 { return $this->_inlineConf; }
	public function hasInlineConf() 		 { return $this->_configName == self::CONF_INLINE; }
	
	public function getJsSrc() 
	{
		if ( $this->useCDN() )
		{	
			$src = "http://cdn.mathjax.org/mathjax/" . $this->getCDNVersion() . "/MathJax.js";
		}
		else
		{
			$uH = \Core::make('helper/concrete/urls');
			$pkg = Package::getByHandle( 'gnt_mathjax');
			$src = $uH->getPackageURL( $pkg ) . '/js/mathjax/MathJax.js';
		}
		$ret = $this->useCommonConf() ? "$src?config=" . $this->getConfigName() : $src;
		return $ret;
	}

	public function __toString() {
		$str = '';


		if ( $this->hasInlineConf() )
		{
			$str .= '<script type="text/x-mathjax-config">' . "\n";
			$str .= $this->getInlineConf();
			$str .= "</script>\n";
		}
		$str .= '<script type="text/javascript" src="' . $this->getJsSrc() . '"></script>' . "\n";
		return $str;
	}

	public static function registerGlobalAsset() 
	{ 
		$al = AssetList::getInstance();
		$al->registerAsset( self::instance() ); 
		$al->registerGroup( self::$handle, array( array( 'javascript', self::$handle ) ) );
	}
}


// vim: set noexpandtab ts=4 :
