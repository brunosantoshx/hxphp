<?php
namespace HXPHP\System\Storage;

interface StorageInterface
{
    /**
     * Usar para armazenar um valor no storage
     *
     * @param string $name  Nome do indice para o valor
     * @param $this
     */
    public function set(string $name, $value);
    /**
     * Usar para resgatar um valor no storage
     *
     * @param  string $name Nome do indice que o valor foi armazenado
     * @return *
     */
    public function get(string $name);
    /**
     * Usar para verificar se um indice existe no storage
     *
     * @param  string $name
     * @return boolean
     */
    public function exists(string $name): bool;
    /**
     * Usar para apagar um indice do storage
     *
     * @param  string $name
     * @return boolean
     */
    public function clear(string $name);
}