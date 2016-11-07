<?php 
namespace Concrete\Package\ResponsiveEmbed\Block\ResponsiveEmbed;
use Loader;
use \Concrete\Core\Block\BlockController;
use Core;

class Controller extends BlockController
{
    protected $btTable = 'btResponsiveEmbed';
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "350";
	protected $btDefaultSet = 'multimedia';
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;

    public $srcURL = "";
    public $aspectW = "16";
    public $aspectH = "9";
	public $cHeight = "35";

    /**
     * Used for localization. If we want to localize the name/description we have to include this
     */
    public function getBlockTypeDescription()
    {
        return t("Embeds a external content (iframe) responsively in your web page.");
    }

    public function getBlockTypeName()
    {
        return t("Responsively embed");
    }

/*    public function __construct($obj = null)
    {
        parent::__construct($obj);
    }

    public function registerViewAssets()
    {
        $this->requireAsset('swfobject');
    }*/

    public function view()
    {
        $this->set('bID', $this->bID);
        $this->set('srcURL', $this->srcURL);
        $this->set('aspectH', $this->aspectH);
        $this->set('aspectW', $this->aspectW);
        $this->set('cHeight', $this->cHeight);
    }
    public function validate($data)
    {
        $e = Core::make('error');
        if (!$data['srcURL']) {
            $e->add(t('Source URL is required'));
        }
        return $e;
    }

    public function save($data)
    {
		//TODO: Allow HTML snippet as well and then parse src from that
        $args['srcURL'] = isset($data['srcURL']) ? trim($data['srcURL']) : '';
        $args['aspectH'] = isset($data['aspectH']) ? trim($data['aspectH']) : 16;
        $args['aspectW'] = isset($data['aspectW']) ? trim($data['aspectW']) : 9;
        $args['cHeight'] = isset($data['cHeight']) ? trim($data['cHeight']) : 0;
        parent::save($args);
    }

}