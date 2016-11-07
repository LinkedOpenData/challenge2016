<?php 

namespace Concrete\Package\CustomizableTwitterFeed\Block\CustomizableTwitterFeed;

defined('C5_EXECUTE') or die("Access Denied.");
use Concrete\Core\Block\BlockController;
use Core;

class Controller extends BlockController
{

    public $helpers = array('form');

    protected $btInterfaceWidth = 450;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btInterfaceHeight = 560;
    protected $btExportFileColumns = array('fID');
    protected $btTable = 'btCustomizableTwitterFeed';
    protected $btDefaultSet = 'social';

    public function getBlockTypeDescription()
    {
        return t("Add a customizable Twitter feed on your pages.");
    }

    public function getBlockTypeName()
    {
        return t("Customizable Twitter Feed");
    }

}