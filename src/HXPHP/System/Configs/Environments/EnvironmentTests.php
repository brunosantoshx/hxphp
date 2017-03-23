<?php
namespace HXPHP\System\Configs\Environments;

use HXPHP\System\Configs as Configs;

class EnvironmentTests extends Configs\AbstractEnvironment
{
    public function __construct()
    {
        ini_set('display_errors', 1);
    }
}