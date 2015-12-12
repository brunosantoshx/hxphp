<?php

namespace HXPHP\System\Configs\Modules;

class Auth
{
	public $after_login = null;
	public $after_logout = null;

	public function setURLs($after_login, $after_logout)
	{
		$this->after_login = $after_login;
		$this->after_logout = $after_logout;

		return $this;
	}
}