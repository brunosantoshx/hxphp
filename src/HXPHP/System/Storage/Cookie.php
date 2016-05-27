<?php

namespace HXPHP\System\Storage;

class Cookie implements StorageInterface
{

    /**
     * Cria um cookie
     * @param string $name  Nome do cookie
     * @param string $value Conteúdo do cookie
     * @param timestamp $time Tempo de duração do cookie
     */
    public function set($name, $value = null, $time = 31556926)
    {
        $cookieParams = session_get_cookie_params();

        if(is_array($name))
            foreach ($name as $cookie => $value)
                setcookie($cookie, $value, time() + $time, $cookieParams['path'], $cookieParams['domain'] ,FALSE, TRUE);
        else
            setcookie($name, $value, time() + $time, $cookieParams['path'], $cookieParams['domain'] ,FALSE, TRUE);

        return $this;
    }

    /**
     * Seleciona um cookie
     * @param  string $name Nome do cookie
     * @return string       Conteúdo do cookie
     */
    public function get($name)
    {
        if(is_array($name))
        {
            $cookies = [];

            foreach ($name as $cookie)
                if ($this->exists($cookie))
                    $cookies[] = $_COOKIE[$cookie];

            return $cookies;
        }
        else
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
        if(is_array($name))
        {
            $cookies = [];

            foreach ($name as $cookie)
                $cookies[] = isset($_COOKIE[$cookie]);

            return $cookies;
        }
        else
            return isset($_COOKIE[$name]);
    }

    /**
     * Exclui um cookie
     * @param  string $name Nome do cookie
     */
    public function clear($name)
    {
        if(is_array($name))
        {
            foreach ($name as $cookie)
                if ($this->exists($cookie))
                    $this->set($cookie, null, -1);
        }
        else
            if ($this->exists($name))
                return $this->set($name, null, -1);
    }
}