<?php 
namespace Concrete\Package\CustomizableTwitterFeed;
use Package;
use BlockType;
use Concrete\Core\Block\BlockType\Set;
use Loader;

defined('C5_EXECUTE') or die("Access Denied.");

/*
Deluxe Customizable Twitter Feed by Karl Dilkington (aka MrKDilkington)
This software is licensed under the terms described in the concrete5.org marketplace.
Please find the add-on there for the latest license copy.
*/

class Controller extends Package
{

	protected $pkgHandle = 'customizable_twitter_feed';
	protected $appVersionRequired = '5.7.3';
	protected $pkgVersion = '0.9.3';

	public function getPackageName()
	{
		return t('Deluxe Customizable Twitter Feed');
	}

	public function getPackageDescription()
	{
		return t('Add a customizable Twitter feed on your pages.');
	}

	public function install()
	{
	    $pkg = parent::install();
	    $this->configurePackage($pkg);
	}

	public function configurePackage($pkg)
	{
		$blk = BlockType::getByHandle('customizable_twitter_feed');
		if(!is_object($blk) ) {
			BlockType::installBlockTypeFromPackage('customizable_twitter_feed', $pkg);
		}
	}

}