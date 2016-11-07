<?php 
namespace Concrete\Package\SocialShareLite\Controller\SinglePage\Dashboard\System;

use \Concrete\Core\Page\Controller\DashboardPageController;

class SocialShareLite extends DashboardPageController
{
    public function view()
    {
        $this->redirect('/dashboard/system/social_share_lite/settings');
    }
}