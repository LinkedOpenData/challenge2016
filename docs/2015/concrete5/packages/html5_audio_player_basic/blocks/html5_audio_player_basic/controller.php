<?php 
namespace Concrete\Package\Html5AudioPlayerBasic\Block\Html5AudioPlayerBasic;

use Concrete\Core\Block\BlockController;
use File;
use Loader;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{

    protected $btTable = "btHtml5AudioPlayerBasic";
    protected $btInterfaceWidth = "600";
    protected $btInterfaceHeight = "500";
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;
    protected $btDefaultSet = 'multimedia';

    public function getBlockTypeName()
    {
        return t('HTML5 Audio Player Basic');
    }

    public function getBlockTypeDescription()
    {
        return t('Basic HTML5/flash audio player built using the jPlayer jQuery plugin');
    }

    public function getJavaScriptStrings()
    {
        return array(
            'choose-file' => t('Choose an Audio File')
        );
    }

	private function getFileInfo($f, $fallback = null)
    {
        if (!is_object($f)) {
            return false;
        }

        $info = array();

        $ext = $this->processExtension($f->getExtension());
        $info[$ext] = $f->getRelativePath();
        $info['downloadURL'] = $f->getDownloadURL();
        $info['title'] = $f->getTitle();
        $info['description'] = $f->getDescription();
        $info['formats'] = array($ext);
        $info['free'] = (bool) $this->free;

        if (is_object($fallback)) {
            $ext2 = $this->processExtension($fallback->getExtension());
            $info[$ext2] = $fallback->getRelativePath();
            $info['formats'][] = $ext2;
        }

        return $info;
    }

    private function processExtension($ext) {
        $ext = strtolower($ext);
        if ($ext == 'ogg') {
            $ext  = 'oga';
        }
        return $ext;
    }

	public function registerViewAssets()
    {
        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('javascript', 'jplayer');
        $this->requireAsset('css', 'font-awesome');
    }

    public function view()
    {
		$f = File::getByID(intval($this->fID));
		$fallback = File::getByID(intval($this->secondaryfID));

		$fileInfo = $this->getFileInfo($f, $fallback);

		if ($this->titleSource == 'DESCRIPTION') {
			$fileInfo['title'] = $fileInfo['description'];
		} elseif ($this->titleSource == 'CUSTOM') {
			$fileInfo['title'] = $this->title;
		}

		$options = array (
			'volume' => $this->initialVolume / 100,
			'autoPlay' => (bool) $this->autoPlay,
			'loop' => (bool) $this->loopAudio,
			'pauseOthers' => (bool) $this->pauseOthers,
			'swfPath' => REL_DIR_PACKAGES . '/html5_audio_player_basic/flash/',
			'supplied' => implode(', ', $fileInfo['formats']),
            'wmode' => 'window',
            'cssSelectorAncestor' => '#jp_container_' . $this->bID,
            'files' => $fileInfo
		);

		$json = \Core::make('helper/json');
		$this->set('options', $json->encode($options));
    }

    public function add()
    {
        $this->set('initialVolume', 80);
    }

    public function save($data)
    {
        $data['loopAudio'] = intval($data['loopAudio']);
        $data['autoPlay'] = intval($data['autoPlay']);
        $data['pauseOthers'] = intval($data['pauseOthers']);
        parent::save($data);
    }
}
