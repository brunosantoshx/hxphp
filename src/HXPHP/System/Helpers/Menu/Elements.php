<?php
namespace HXPHP\System\Helpers\Menu;

class Elements
{

    /**
     * Elementos HTML utilizados na renderização do menu
     * @var array
     */
    private static $elements = [
        /**
         * Tag inicio container
         * ID
         * Classe
         * Conteúdo do container
         * Tag final container
         */
        'container' => '
			<%s id="%s" class="%s">
				%s
			</%s>
		',
        /**
         * Classe do menu
         * ID do menu
         * Conteúdo do menu
         */
        'menu' => '<ul class="%s" id="%s">%s</ul>',
        /**
         * Classe
         * Classe ativa
         * Conteúdo
         */
        'menu_item' => '<li class="%s %s">%s</li>',
        /**
         * Link
         * Classe
         * Classe ativa
         * Título
         * Ícone (Font-Awesome)
         * Before
         * Título
         * After
         */
        'link' => '<a href="%s" class="%s %s" title="%s"><i class="fa fa-%s"></i> %s%s%s</a>',
        /**
         * Link
         * Classe
         * Classe Ativa
         * Attrs
         * Título
         * Ícone
         * Before
         * Título
         * After
         * Dropdown
         */
        'link_with_dropdown' => '
			<a href="#" data-href="#hxphp-submenu-%s" class="%s %s" %s title="%s">
				<i class="fa fa-%s"></i> %s%s%s <i class="arrow fa fa-angle-down pull-right"></i>
			</a>
			%s
		',
        /**
         * ID dropdown
         * Classe dropdown
         * Conteúdo
         */
        'dropdown' => '<ul id="hxphp-submenu-%s" class="%s">%s</ul>',
        /**
         * Classe
         * Classe ativa
         * Conteúdo
         */
        'dropdown_item' => '<li class="%s %s">%s</li>'
    ];

    /**
     * Retorna um elemento
     * @param  string $name Nome do elemento
     * @param  array  $args Array para preencher os coringas presentes nos elementos
     * @return string       HTML do elemento
     */
    public static function get(string $name, array $args = []): string
    {
        if (!self::$elements[$name])
            return false;

        if ($args) {
            $args = array_values($args);
            array_unshift($args, self::$elements[$name]);

            return call_user_func_array('sprintf', $args);
        }

        return self::$elements[$name];
    }
}