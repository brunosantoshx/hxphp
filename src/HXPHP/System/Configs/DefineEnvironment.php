<?php

namespace HXPHP\System\Configs;

use HXPHP\System\Http\Request as Request;

class DefineEnvironment
{
	private $currentEnviroment;

	public function __construct()
	{
		$request = new Request;
		$server_name = $request->server('SERVER_NAME');
        
        $development = new Environments\EnvironmentDevelopment;
		$production = new Environments\EnvironmentProduction;

		if (in_array($server_name, $development->servers))
            $this->currentEnviroment = 'development';

		elseif (in_array($server_name, $production->servers))
            $this->currentEnviroment = 'production';
                
        else
            $this->currentEnviroment = 'tests';


		return $this->currentEnviroment;
	}

	public function setDefaultEnv($environment)
	{
		$env = new Environment;
		if (is_object($env->add($environment)))
			$this->currentEnviroment = $environment;
	}

	public function getDefault()
	{
		return $this->currentEnviroment;
	}
}
