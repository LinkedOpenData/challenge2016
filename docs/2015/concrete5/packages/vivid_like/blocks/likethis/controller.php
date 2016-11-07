<?php 
namespace Concrete\Package\VividLike\Block\Likethis;
use \Concrete\Core\Block\BlockController;
use Loader;
use Page;

defined('C5_EXECUTE') or die(_("Access Denied.")); 
class Controller extends BlockController
{
    protected $btTable = 'btVividLike';
    protected $btInterfaceWidth = "400";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "365";

    public function getBlockTypeDescription()
    {
        return t("Add 'Like' button to this page");
    }

    public function getBlockTypeName()
    {
        return t("Like This");
    }
}