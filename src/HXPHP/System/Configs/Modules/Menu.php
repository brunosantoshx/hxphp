<?php
namespace HXPHP\System\Configs\Modules;

class Menu
{
    public $configs = [
        'container' => 'nav',
        'container_id' => '',
        'container_class' => 'navbar navbar-default',
        'menu_id' => 'menu',
        'menu_class' => 'navbar-nav nav',
        'menu_item_class' => 'menu-item',
        'menu_item_active_class' => 'active',
        'menu_item_dropdown_class' => 'dropdown',
        'link_before' => '<span>',
        'link_after' => '</span>',
        'link_class' => 'menu-link',
        'link_active_class' => 'menu-active-link',
        'link_dropdown_class' => 'dropdown-toggle',
        'link_dropdown_attrs' => [
            'data-toggle' => 'dropdown'
        ],
        'dropdown_class' => 'dropdown-menu',
        'dropdown_item_class' => 'dropdown-item',
        'dropdown_item_active_class' => 'active'
    ];
    
    public $itens = [];

    public function setConfigs(array $configs): array
    {
        return $this->configs = array_merge($this->configs, $configs);
    }

    public function setMenus(array $itens, string $role = 'default'): array
    {
        return $this->itens[$role] = $itens;
    }
}