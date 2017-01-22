<?php

namespace HXPHP\System\Configs;

class DefineEnvironment
{
	private $currentEnviroment;

	public function __construct()
	{
		$server_name = $_SERVER['SERVER_NAME'];
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
