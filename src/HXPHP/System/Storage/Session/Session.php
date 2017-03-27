<?php
namespace HXPHP\System\Storage\Session;

class Session implements \HXPHP\System\Storage\StorageInterface
{
    /**
     * Prefixo das sessões
     */
    const PREFIX = 'hxphp_storage_session';

    /**
     * Método que cria uma sessão
     * @param string $name  Nome da sessão
     * @param string $value Conteúdo da sessão
     * @param int $timeout  Tempo de expiração da sessão
     */
    public function set($name, $value, $timeout = null)
    {
        $_SESSION[self::PREFIX][$name] = $value;

        if ($timeout && is_int($timeout)) {
            $_SESSION[self::PREFIX][$name . '_created_at'] = time();
            $_SESSION[self::PREFIX][$name . '_timeout'] = $timeout;
        }

        return $this;
    }

    /**
     * Método que seleciona uma sessão
     * @param  string $name Nome da sessão
     * @return string       Conteúdo da sessão
     */
    public function get($name)
    {
        if ($this->exists($name)) {
            if (!$this->hasExpired($name))
                return $_SESSION[self::PREFIX][$name];
            else
                return false;
        }

        return null;
    }

    /**
     * Verifica a existência da sessão
     * @param  string  $name Nome da sessão
     * @return boolean       Status do processo
     */
    public function exists($name)
    {
        return isset($_SESSION[self::PREFIX][$name]);
    }

    /**
     * Verifica se uma sessão já expirou
     * @param string $name   Nome da sessão
     * @return boolean       Sessão expirada ou não
     */
    public function hasExpired($name)
    {
        if (!$this->exists($name . '_timeout'))
            return false;

        if (!$this->exists($name . '_created_at'))
            throw new \LogicException('A sessão < ' . $name . '_created_at > não existe.');

        if ($this->get($name . '_created_at') + $this->get($name . '_timeout') < time())
            return true;
    }

    /**
     * Quantidade de tempo restante para o timeout de uma sessão
     * @param string $name   Nome da sessão
     * @return date          Quantidade de tempo restante para o timeout
     */
    public function getTimeLeftOf($name)
    {
        if ($this->hasExpired($name))
            return 0;

        return ($this->get($name . '_created_at') + $this->get($name . '_timeout')) - time();
    }

    /**
     * Exclui uma sessão
     * @param  string $name Nome da sessão
     */
    public function clear($name)
    {
        if ($this->exists($name))
            unset($_SESSION[self::PREFIX][$name]);
    }
}