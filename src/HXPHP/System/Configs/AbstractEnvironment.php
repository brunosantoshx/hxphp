<?php
namespace HXPHP\System\Configs;

abstract class AbstractEnvironment
{
    public $baseURI;

    public function __construct()
    {
        //Configurações variáveis por ambiente
        $this->baseURI = '/';

        $load = new LoadModules;
        return $load->loadModules($this);
    }
}
