<?php

namespace Controllers\Admin;

use HXPHP\System\Controller;

class IndexController extends \HXPHP\System\Controller
{
    public function indexAction()
    {
        $this->view->setPath('havefun');
    }
}
