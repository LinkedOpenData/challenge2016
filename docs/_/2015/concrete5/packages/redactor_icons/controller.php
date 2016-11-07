<?php 
namespace Concrete\Package\RedactorIcons;
 
use Concrete\Core\Editor\Plugin;
use \Core;
use \AssetList;
 
class Controller extends \Concrete\Core\Package\Package
{
 
    protected $pkgHandle = 'redactor_icons';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '0.9';
 
    public function getPackageDescription()
    {
        return t("Adds icons to the rich text editor.");
    }
 
    public function getPackageName()
    {
        return t("Icons for Redactor");
    }
 
    public function on_start()
    {
        $al = AssetList::getInstance();
        $al->register(
            'javascript', 'editor/plugin/awesome', 'js/awesome.js', 
                            array(), 'redactor_icons'
        );
        $al->register(
            'css', 'editor/plugin/awesome', 'css/awesome.css', 
                            array(), 'redactor_icons'
        );
        $al->registerGroup('editor/plugin/awesome', array(
            array('javascript', 'editor/plugin/awesome'),
            array('css', 'editor/plugin/awesome')
        ));
        $al->register(
            'javascript', 'bootstrap-select', 'js/bootstrap-select.min.js', 
                            array(), 'redactor_icons'
        );
        $al->register(
            'css', 'bootstrap-select', 'css/bootstrap-select.min.css', 
                            array(), 'redactor_icons'
        );
        $al->registerGroup('bootstrap-select', array(
            array('javascript', 'bootstrap-select'),
            array('css', 'bootstrap-select')
        ));
        $plugin = new Plugin();
        $plugin->setKey('awesome');
        $plugin->setName('Font Awesome Icons');
        $plugin->requireAsset('editor/plugin/awesome');
        $plugin->requireAsset('bootstrap-select');
 
        Core::make('editor')->getPluginManager()->register($plugin);
    }
 
}