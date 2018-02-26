<?php
namespace HXPHP\System\Configs\Environments;

use HXPHP\System\Configs\AbstractEnvironment;

class Development extends AbstractEnvironment
{
    public $servers;

    public function __construct()
    {
        parent::__construct();
        $this->servers = [
            'localhost',
            '127.0.0.1',
            '::1'
        ];
    }
}