<?php
namespace HXPHP\System\Configs;

use HXPHP\System\Http\Request;

class Bootstrap
{
    const DS = DIRECTORY_SEPARATOR;

    public function __construct()
    {
        $this->setEnvVariables();
    }

    private function setEnvVariables()
    {
        putenv('ROOT_PATH=' . dirname(__FILE__, 5) . static::DS);
        putenv('APP_PATH=' . getenv('ROOT_PATH') . 'app' . static::DS);
        putenv('TEMPLATES_PATH=' . getenv('ROOT_PATH') . 'templates' . static::DS);
        putenv('HXPHP_VERSION=3.0.0-rc.6');
    }
}