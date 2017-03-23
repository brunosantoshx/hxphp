<?php
namespace HXPHP\System\Configs\Environments;

use HXPHP\System\Configs as Configs;

class EnvironmentDevelopment extends Configs\AbstractEnvironment
{
    public $servers;

    public function __construct()
    {
        parent::__construct();
        $this->servers = [
            'localhost',
            '127.0.0.1'
        ];

        return $this;
    }
}