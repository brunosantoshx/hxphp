<?php
namespace HXPHP\System\Configs;

use HXPHP\System\Http\Request as Request;

class GlobalConfig
{
    public $site;
    public $models;
    public $views;
    public $controllers;
    public $title;

    public function __construct()
    {
        $this->site = new \stdClass;

        $this->models = new \stdClass;
        $this->views = new \stdClass;
        $this->controllers = new \stdClass;

        //Site
        $request = new Request();
        $https = $request->server('HTTPS');

        $this->site->protocol = ($https && $https != 'off') ? 'https' : 'http';
        $this->site->host = $request->server('HTTP_HOST');
        $this->site->url = $this->site->protocol . '://' . $this->site->host;

        //Models
        $this->models->directory = APP_PATH . 'models' . DS;

        //Views
        $this->views->directory = APP_PATH . 'views' . DS;
        $this->views->extension = '.phtml';

        //Controller
        $this->controllers->directory = APP_PATH . 'controllers' . DS;
        $this->controllers->notFound = 'Error404Controller';

        //General
        $this->title = 'HXPHP Framework';

        return $this;
    }
}