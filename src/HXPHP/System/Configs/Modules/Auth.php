<?php
namespace HXPHP\System\Configs\Modules;

class Auth
{
    public $after_login = null;
    public $after_logout = null;

    public function setURLs(string $after_login, string $after_logout, string $subfolder = 'default'): self
    {
        $this->after_login[$subfolder] = $after_login;
        $this->after_logout[$subfolder] = $after_logout;

        return $this;
    }
}