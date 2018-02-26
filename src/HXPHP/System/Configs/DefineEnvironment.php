<?php
namespace HXPHP\System\Configs;

use HXPHP\System\Configs\Environments\Development;

class DefineEnvironment
{
    private $currentEnviroment = 'development';

    public function __construct()
    {
        if (array_key_exists('SERVER_NAME', $_SERVER)
            && array_key_exists('SERVER_ADDR', $_SERVER)) {
            $this->setCurrentEnviroment();
        }
        else {
            $this->currentEnviroment = 'tests';
        }
    }

    public function setCurrentEnviroment()
    {
        $development = new Development;

        $server_name = $_SERVER['SERVER_NAME'];
        $server_addr = $_SERVER['SERVER_ADDR'];

        (in_array($server_addr || $server_name, $development->servers)) ?
                        $this->currentEnviroment = 'development' :
                        $this->currentEnviroment = 'production';
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