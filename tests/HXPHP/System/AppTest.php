<?php
namespace Tests\System;

use Tests\BaseTestCase;

final class AppTest extends BaseTestCase
{
	public function test_PHP_ActiveRecord_instance()
	{
		$instance = $this->app->ActiveRecord();

		$this->assertInstanceOf('\ActiveRecord\Config', $instance);
	}
}