<?php

namespace HXPHP\System\Configs;

use HXPHP\System\Tools;

class LoadModules
{
    private $modules;

    public function __construct()
    {
        $register = new RegisterModules;

        $this->modules = $register->modules;
    }

    public function loadModules($obj)
    {
        foreach ($this->modules as $module) {
            $module_class = Tools::filteredName(ucwords($module));
            $app = 'APP\Modules\\'.$module_class.'\\'.$module_class.'Config';
            $object = 'HXPHP\System\Configs\Modules\\'.$module_class;

            if (class_exists($object))
                $obj->$module = new $object();
            elseif (class_exists($app))
                $obj->$module = new $app();
            else
                throw new \Exception("O modulo <'$object ou $app'> informado nao existe.", 1);

        }
        return $obj;
    }
}