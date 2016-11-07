<?php 
namespace Concrete\Package\SocialShareLite\Controller\SinglePage\Dashboard\System\SocialShareLite;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Package;

class Settings extends DashboardPageController
{    
    public function view()
    {
        $pkg = Package::getByHandle('social_share_lite');
        $disable_scripts = $pkg->getConfig()->get('concrete.sharing.disable_scripts');
        $this->set('disable_scripts', $disable_scripts);
    }

    public function updated()
    {
        $this->set('message', t("Settings saved."));
        $this->view();
    }
    
    public function save_settings()
    {
        if ($this->token->validate("save_settings")) {
            if ($this->isPost()) {
                $disable_scripts = $this->post('disable_scripts');
                $pkg = Package::getByHandle('social_share_lite');
                $pkg->getConfig()->save('concrete.sharing.disable_scripts', $disable_scripts);
                $this->redirect('/dashboard/system/social_share_lite/settings','updated');
            }
        } else {
            $this->set('error', array($this->token->getErrorMessage()));
        }
    }
    
}