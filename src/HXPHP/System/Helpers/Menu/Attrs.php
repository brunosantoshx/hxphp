<?php
namespace HXPHP\System\Helpers\Menu;

class Attrs
{
    /**
     * Renderização dos atributos extras para links de ativação para dropdown
     * @param  array  $attrs Atributos
     * @return string        Atributos no formato HTML
     */
    public static function render(array $attrs): string
    {
        if (!$attrs || !is_array($attrs))
            return null;

        $html = '';

        foreach ($attrs as $attr => $value)
            $html .= ' ' . $attr . '="' . $value . '" ';

        return $html;
    }
}