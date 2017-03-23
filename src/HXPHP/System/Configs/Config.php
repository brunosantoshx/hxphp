<?php
namespace HXPHP\System\Configs;

class Config
{
    public $global;
    public $env;
    public $define;

    public function __construct()
    {
        $this->global = new GlobalConfig;
        $this->env = new Environment;
        $this->define = new DefineEnvironment;
        $this->env->add();
    }

    public function __get($param)
    {
        $current = $this->define->getDefault();

        if (isset($this->env->$current->$param))
            return $this->env->$current->$param;

        else if (isset($this->global->$param))
            return $this->global->$param;


        throw new \Exception("Parametro/Modulo '$param' nao encontrado. Verifique se o ambiente definido esta configurado e os modulo utilizados registrados.", 1);
    }
}