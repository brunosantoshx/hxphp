<?php

namespace HXPHP\System\Configs;

class RegisterModules
{
    public $modules = [];

    public function __construct()
    {
        $modules = [
            'database',
            'mail',
            'menu',
            'auth'
        ];

        $appModules = 'App\\Modules\\Register';

        if(class_exists($appModules)){
            $register = new $appModules();
            $modules = array_merge($modules,$register->modules);
        }

        $this->modules = $modules;

        return $this;
    }
}