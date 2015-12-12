<?php

namespace HXPHP\System\Configs;

class GlobalConfig
{
	public $models;
	public $views;
	public $controllers;
	public $title;

	public function __construct()
	{
		$this->models = new \stdClass;
		$this->views = new \stdClass;
		$this->controllers = new \stdClass;

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
