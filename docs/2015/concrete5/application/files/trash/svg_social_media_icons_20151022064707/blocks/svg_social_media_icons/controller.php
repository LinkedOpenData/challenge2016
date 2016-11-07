<?php 

namespace Concrete\Package\SvgSocialMediaIcons\Block\SvgSocialMediaIcons;

defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Block\BlockController;
use Core;

class Controller extends BlockController
{

    public $helpers = array('form');

    protected $btInterfaceWidth = 450;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = false;
    protected $btCacheBlockOutputOnPost = false;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btInterfaceHeight = 560;
    protected $btExportFileColumns = array('fID');
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

    public function setIconStyleTag($iconStyleTag)
    {
        $this->iconStyleTag = $iconStyleTag;
        return $iconStyleTag;
    }

    public function on_page_view()
    {
        $this->addHeaderItem($this->iconStyleTag);
    }

    public function buildStyleTag($accountName, $iconSize, $iconShape, $iconColor, $iconHover ,$localPath)
    {
        $class = '.' . $accountName . $iconSize . '-' . $iconShape . '-' . $iconColor
                  . "{background:url('" . $localPath . "/images/" . $accountName . $iconSize . '-' . $iconShape . '-' . $iconColor
                  . ".png') no-repeat;background:none,url('" . $localPath . "/images/"
                  . $accountName . '-' . $iconShape . '-' . $iconColor . ".svg') no-repeat;}";

        if ($iconHover == 'hoverOn') {
            $class .= '.' . $accountName . $iconSize . '-' . $iconShape . '-' . $iconColor
                       . ":hover{background:url('" . $localPath . "/images/" . $accountName . $iconSize . '-' . $iconShape
                       . "-hover.png') no-repeat;background:none,url('" . $localPath . "/images/"
                       . $accountName . '-' . $iconShape . "-hover.svg') no-repeat;}";
        }

        return $class;
    }

    public function iconDisplay($accountName, $accountAddress, $iconMargin, $iconSize, $iconShape, $iconColor)
    {
        $class = $accountName . $iconSize . '-' . $iconShape . '-' . $iconColor;
        $iconLink = "<a style=\"margin-left: " . $iconMargin . "px; float: left;\" href=\"" . $accountAddress . "\"><div style=\"height: " . $iconSize . "px; width: " . $iconSize . "px\" class=\"" . $class . "\"></div></a>";

        return $iconLink;
    }

    public function save($args)
    {
        // this is required when saving arrays to the database
        // some information, like arrays, cannot be saved to the database as is
        // serialize() generates a storable representation of the array
        $args['icon'] = serialize($args['icon']);

        parent::save($args);
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
        // the icon array information will be read from the database in a storable format
        // when an array in storable format (serialized), the values cannot be accessed
        // unserialize() takes serialized information and converts it back to a PHP value
        $this->set('icon', unserialize($this->icon));
    }

}