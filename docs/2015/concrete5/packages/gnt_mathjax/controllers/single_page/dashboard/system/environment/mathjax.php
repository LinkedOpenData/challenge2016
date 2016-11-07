<?php    
namespace Concrete\Package\GntMathjax\Controller\SinglePage\Dashboard\System\Environment;

defined('C5_EXECUTE') or die(_("Access Denied."));
/**
 *-----------------------------------------------------------------------------*
 *                                                                             *
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2013 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */

use Package;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Log;
use Page;

class Mathjax extends DashboardPageController
{
	public function __construct(Page $c) 
	{
		parent::__construct($c);

		$this->_pkg = Package::getByHandle( 'gnt_mathjax');
		$this->_errors = \Core::make( 'helper/validation/error' );
		$this->set( 'errors', $this->_errors );
	}

	public function view()
	{
		// Ensure JQuery is loaded (tool is using jQuery.ui to make code resizable

		$this->set( 'useCDN', 		$this->_pkg->useCDN() );
		$this->set( 'CDNversion', 	$this->_pkg->getCDNVersion() );
		$this->set( 'configName', 	$this->_pkg->getDefaultConf() );
		$this->set( 'inlineConfig', $this->_pkg->getInlineConf() );

		$this->requireAsset( 'ace' );
		$this->requireAsset( 'jquery/ui');
	}


	public function save_global_settings()
	{
		$errors = $this->_errors;

		try
		{
			$useCDN = $this->post( 'useCDN' );
			$this->_pkg->setUseCDN( $useCDN != '' and $useCDN != 0  );
			$this->_pkg->setCDNVersion( $this->post('CDNversion') );
			$this->_pkg->setDefaultConf( $this->post('configName') );
			$this->_pkg->setInlineConf( $this->post('inlineConfig') );
		}
		catch ( \Exception $e )
		{
			$errors->add( $e->getMessage() );
			$this->view();
			return;
		}

		$this->redirect( '/dashboard/system/environment/mathjax/updated' );
	}

	public function updated()
	{
		$this->set( 'success', t('Configuration updated') );
		$this->view();
	}
}

// vim: set noexpandtab ts=4 :
