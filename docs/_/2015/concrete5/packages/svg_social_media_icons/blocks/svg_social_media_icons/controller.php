<?php 
namespace Concrete\Package\SvgSocialMediaIcons\Block\SvgSocialMediaIcons;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{

    protected $btInterfaceWidth = 450;
    protected $btInterfaceHeight = 580;
    protected $btCacheBlockOutput = true;
    protected $btTable = 'btSvgSocialMediaIcons';
    protected $btDefaultSet = 'social';

    public function getBlockTypeDescription()
    {
        return t("Add SVG social media icons with PNG fallback on your pages.");
    }

    public function getBlockTypeName()
    {
        return t("SVG Social Media Icons");
    }

    public function edit()
    {
        // the icon array information will be read from the database in a storable format
        // when an array in storable format (serialized), the values cannot be accessed
        // unserialize() takes serialized information and converts it back to a PHP value
        $this->set('icon', unserialize($this->icon));
    }

    public function view()
    {
        // Example: serialized array
        // - only Flickr is checked
        // a:19:{
        //     s:7:"behance";a:1:{s:7:"address";s:0:"";}
        //     s:10:"deviantart";a:1:{s:7:"address";s:0:"";}
        //     s:8:"dribbble";a:1:{s:7:"address";s:0:"";}
        //     s:5:"email";a:1:{s:7:"address";s:0:"";}
        //     s:8:"facebook";a:1:{s:7:"address";s:0:"";}
        //     s:6:"flickr";a:2:{s:7:"checked";s:6:"flickr";s:7:"address";s:0:"";}
        //     s:6:"github";a:1:{s:7:"address";s:0:"";}
        //     s:10:"googleplus";a:1:{s:7:"address";s:0:"";}
        //     s:9:"instagram";a:1:{s:7:"address";s:0:"";}
        //     s:6:"itunes";a:1:{s:7:"address";s:0:"";}
        //     s:8:"linkedin";a:1:{s:7:"address";s:0:"";}
        //     s:9:"pinterest";a:1:{s:7:"address";s:0:"";}
        //     s:5:"skype";a:1:{s:7:"address";s:0:"";}
        //     s:10:"soundcloud";a:1:{s:7:"address";s:0:"";}
        //     s:7:"spotify";a:1:{s:7:"address";s:0:"";}
        //     s:6:"tumblr";a:1:{s:7:"address";s:0:"";}
        //     s:7:"twitter";a:1:{s:7:"address";s:0:"";}
        //     s:5:"vimeo";a:1:{s:7:"address";s:0:"";}
        //     s:7:"youtube";a:1:{s:7:"address";s:0:"";}
        // }
        // the icon array information will be read from the database in a storable format
        // when an array in storable format (serialized), the values cannot be accessed
        // unserialize() takes serialized information and converts it back to a PHP value
        $this->set('icon', unserialize($this->icon));
    }

    public function save($args)
    {
        // Example: array before being serialized
        // - only Flickr is checked
        // array (
        //     'behance' => array('address' => ''),
        //     'deviantart' => array('address' => ''),
        //     'dribbble' => array('address' => ''),
        //     'email' => array('address' => ''),
        //     'facebook' => array('address' => ''),
        //     'flickr' => array('checked' => 'flickr', 'address' => ''),
        //     'github' => array('address' => ''),
        //     'googleplus' => array('address' => ''),
        //     'instagram' => array('address' => ''),
        //     'itunes' => array('address' => ''),
        //     'linkedin' => array('address' => ''),
        //     'pinterest' => array('address' => ''),
        //     'skype' => array('address' => ''),
        //     'soundcloud' => array('address' => ''),
        //     'spotify' => array('address' => ''),
        //     'tumblr' => array('address' => ''),
        //     'twitter' => array('address' => ''),
        //     'vimeo' => array('address' => ''),
        //     'youtube' => array('address' => '')
        // )
        // this is required when saving arrays to the database
        // some information, like arrays, cannot be saved to the database as is
        // serialize() generates a storable representation of the array
        $args['icon'] = serialize($args['icon']);

        parent::save($args);
    }

}