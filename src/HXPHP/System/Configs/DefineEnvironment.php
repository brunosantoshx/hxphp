<?php
namespace HXPHP\System\Configs;

class DefineEnvironment
{
    private $currentEnviroment;

    public function __construct()
    {
        $server_name = $_SERVER['SERVER_NAME'];
        $server_addr = $_SERVER['SERVER_ADDR'];
        $development = new Environments\EnvironmentDevelopment;

        (in_array($server_addr || $server_name, $development->servers)) ?
                        $this->currentEnviroment = 'development' :
                        $this->currentEnviroment = 'production';


        return $this->currentEnviroment;
    }

    public function setDefaultEnv(string $environment)
    {
        $env = new Environment;
        if (is_object($env->add($environment)))
            $this->currentEnviroment = $environment;
    }
    
    public function getDefault(): string
    {
        return $this->currentEnviroment;
    }
}

trait CurrentEnviroment
{
    public function getCurrentEnvironment(): string
    {
        $default = new DefineEnvironment;
        return $default->getDefault();
    }
}