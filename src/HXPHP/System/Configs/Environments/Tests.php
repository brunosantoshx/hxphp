<?php
namespace HXPHP\System\Configs\Environments;

use HXPHP\System\Configs\AbstractEnvironment;

class Tests extends AbstractEnvironment
{
    public function __construct()
    {
    	parent::__construct();
    	
        ini_set('display_errors', 1);
    }
}