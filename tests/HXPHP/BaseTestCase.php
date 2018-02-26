<?php
namespace Tests;

use HXPHP\System\App;
use HXPHP\System\Configs\Config;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
	protected $baseURI = 'https://hxphp.dev';

	private $configs;

	protected $app;

	public function __construct()
	{
		parent::__construct();

		$this->createConfigs()
				->createApplication();
	}

	private function createConfigs()
	{
		$this->configs = new Config;

		return $this;
	}

	public function createApplication()
	{
		$this->app = new App($this->configs);

		return $this;
	}
}
