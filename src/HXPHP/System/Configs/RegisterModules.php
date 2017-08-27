<?php
namespace HXPHP\System\Configs;

class RegisterModules
{
    public $modules = [];

    public function __construct()
    {
        $this->modules = [
            'database',
            'mail',
            'menu',
            'auth'
        ];
    }
}