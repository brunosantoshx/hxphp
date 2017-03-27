<?php
namespace HXPHP\System\Configs;

class DefineEnvironment
{
    private $currentEnviroment;

    public function __construct()
    {
        $server_name = $_SERVER['SERVER_NAME'];
        $development = new Environments\EnvironmentDevelopment;

        (in_array($server_name, $development->servers)) ?
                        $this->currentEnviroment = 'development' :
                        $this->currentEnviroment = 'production';


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

trait CurrentEnviroment
{
    public function getCurrentEnvironment()
    {
        $default = new DefineEnvironment;
        return $default->getDefault();
    }
}
