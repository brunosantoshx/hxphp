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
     * @param mixed $value Conteúdo da sessão
     * @param int $timeout  Tempo de expiração da sessão
     */
    public function set(string $name, $value, int $timeout = null): self
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
    public function get(string $name)
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
    public function exists(string $name): bool
    {
        return isset($_SESSION[self::PREFIX][$name]);
    }

    /**
     * Verifica se uma sessão já expirou
     * @param string $name   Nome da sessão
     * @return boolean       Sessão expirada ou não
     */
    public function hasExpired(string $name): bool
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
    public function getTimeLeftOf(string $name): int
    {
        if ($this->hasExpired($name))
            return 0;

        return ($this->get($name . '_created_at') + $this->get($name . '_timeout')) - time();
    }

    /**
     * Exclui uma sessão
     * @param  string $name Nome da sessão
     */
    public function clear(string $name)
    {
        if ($this->exists($name))
            unset($_SESSION[self::PREFIX][$name]);
    }
}