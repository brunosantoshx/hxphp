<?php
namespace HXPHP\System\Storage\Cookie;

class Cookie implements \HXPHP\System\Storage\StorageInterface
{
    /**
     * Cria um cookie
     * @param string $name  Nome do cookie
     * @param string $value Conteúdo do cookie
     * @param timestamp $time Tempo de duração do cookie
     */
    public function set($name, $value, $time = 31556926)
    {
        $cookieParams = session_get_cookie_params();

        setcookie($name, $value, time() + $time, $cookieParams['path'], $cookieParams['domain'], false, true);

        return $this;
    }

    /**
     * Seleciona um cookie
     * @param  string $name Nome do cookie
     * @return string       Conteúdo do cookie
     */
    public function get($name)
    {
        if ($this->exists($name))
            return $_COOKIE[$name];

        return null;
    }

    /**
     * Verifica a existência do cookie
     * @param  string  $name Nome do cookie
     * @return boolean       Status do processo
     */
    public function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Exclui um cookie
     * @param  string $name Nome do cookie
     */
    public function clear($name)
    {
        if ($this->exists($name))
            return $this->set($name, NULL, -1);
    }
}