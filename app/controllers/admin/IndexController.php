<?php
namespace App\Controllers\Admin;

use HXPHP\System\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->setPath('havefun');
    }
}