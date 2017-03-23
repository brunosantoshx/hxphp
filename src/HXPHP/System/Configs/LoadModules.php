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
            $object = 'HXPHP\System\Configs\Modules\\' . $module_class;

            if (!class_exists($object))
                throw new \Exception("O modulo <'$object'> informado nao existe.", 1);
            else
                $obj->$module = new $object();
        }
        return $obj;
    }
}