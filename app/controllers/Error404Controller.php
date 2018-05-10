<?php
namespace App\Controllers;
use HXPHP\System\Controller;

header("HTTP/1.0 404 Not Found");

class Error404Controller extends Controller
{
    public function indexAction()
    {
        $this->view->setAssets('css', $this->configs->baseURI . 'public/css/error.css');
    }
}