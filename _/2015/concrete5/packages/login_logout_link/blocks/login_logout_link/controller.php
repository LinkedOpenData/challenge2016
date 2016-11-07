<?php 

namespace Concrete\Package\LoginLogoutLink\Block\LoginLogoutLink;

use Concrete\Core\Block\BlockController;
use Page;
use URL;
use User;
use Concrete\Core\Validation\CSRF\Token;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController
{
    public $helpers = array('form');

    protected $btInterfaceWidth = 400;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btInterfaceHeight = 400;
    protected $btTable = 'btLoginLogoutLink';
    protected $btWrapperClass = 'ccm-ui';

    public function getBlockTypeDescription()
    {
        return t("Adds a Login/Logout link");
    }

    public function getBlockTypeName()
    {
        return t("Login/Logout Link");
    }

    public function view()
    {
        if (!$this->formatting) {
            $this->set('formatting', 'p');
        }
        if (!id(new User())->isLoggedIn()) {
            $url = URL::to('/login');
            $label = ($this->loginLabel) ? $this->loginLabel : 'Log in';
        } else {
            $url = URL::to('/login', 'logout', id(new Token())->generate('logout'));
            $label = ($this->logoutLabel) ? $this->logoutLabel : 'Log out';
        }
        $this->set('label', $label);
        $this->set('url', $url);
    }

}
