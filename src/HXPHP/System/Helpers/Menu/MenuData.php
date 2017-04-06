<?php
namespace HXPHP\System\Helpers\Menu;

class MenuData
{
    /**
     * Extrair dados da key dos menus
     * @param  string $key Titulo/Icone
     * @return object      Objeto com dados extraídos
     */
    public static function get(string $key): \stdClass
    {
        $obj = new \stdClass;

        $explode = explode('/', $key);

        $obj->title = $explode[0];
        $obj->icon = ($explode[1]) ? $explode[1] : '';

        return $obj;
    }
}