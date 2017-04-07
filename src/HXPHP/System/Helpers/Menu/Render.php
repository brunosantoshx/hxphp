<?php
namespace HXPHP\System\Helpers\Menu;

class Render
{
    /**
     * Dependências
     * @var object
     */
    private $realLink = null;
    private $checkActive = null;

    /**
     * Dados do módulo de configurações do MenuHelper
     * @var array
     */
    private $menu_itens = [];
    private $menu_configs = [];

    /**
     * Conteúdo HTML do menu renderizado
     * @var string
     */
    private $html;

    public function __construct(
    RealLink $realLink, CheckActive $checkActive, array $menu_itens, array $menu_configs
    )
    {
        $this->realLink = $realLink;
        $this->checkActive = $checkActive;

        $this->menu_itens = $menu_itens;
        $this->menu_configs = $menu_configs;
    }

    /**
     * Renderiza o menu em HTML
     */
    public function getHTML(string $role = 'default'): string
    {
        $menu_itens = ($this->menu_itens[$role]) ? $this->menu_itens[$role] : [];
        $menu_configs = $this->menu_configs;

        if (!($menu_itens) || !is_array($menu_itens))
            return 'Nenhum menu foi definido para o seguinte nivel de acesso: <strong>' . $role . '</strong>';

        $itens = '';

        $i = 0;

        foreach ($menu_itens as $key => $value) {
            $i++;
            $menu_data = MenuData::get($key);
            $real_link = $this->realLink->get($value);

            // Dropdown
            if (is_array($value) && ($value)) {
                $dropdown_itens = '';

                foreach ($value as $dropdown_key => $dropdown_value) {
                    $submenu_data = MenuData::get($dropdown_key);
                    $submenu_real_link = $this->realLink->get($dropdown_value);

                    $submenu_link_active = ($this->checkActive->link($submenu_real_link)) ? $menu_configs['link_active_class'] : '';

                    $link = Elements::get('link', [
                                $submenu_real_link,
                                $menu_configs['link_class'],
                                $submenu_link_active,
                                $submenu_data->title,
                                $submenu_data->icon,
                                $menu_configs['link_before'],
                                $submenu_data->title,
                                $menu_configs['link_after']
                    ]);

                    $submenu_active = ($this->checkActive->link($submenu_real_link)) ? $menu_configs['dropdown_item_active_class'] : '';

                    $dropdown_itens .= Elements::get('dropdown_item', [
                                $menu_configs['dropdown_item_class'],
                                $submenu_active,
                                $link
                    ]);
                }

                $dropdown = Elements::get('dropdown', [
                            $i,
                            $menu_configs['dropdown_class'],
                            $dropdown_itens
                ]);

                $attrs = Attrs::render($menu_configs['link_dropdown_attrs']);
                $active = ($this->checkActive->dropdown($value)) ? $menu_configs['link_active_class'] : '';

                $link = Elements::get('link_with_dropdown', [
                            $i,
                            $menu_configs['link_dropdown_class'],
                            $active,
                            $attrs,
                            $menu_data->title,
                            $menu_data->icon,
                            $menu_configs['link_before'],
                            $menu_data->title,
                            $menu_configs['link_after'],
                            $dropdown
                ]);

                $active = ($this->checkActive->dropdown($value)) ? $menu_configs['menu_item_active_class'] : '';

                $itens .= Elements::get('menu_item', [
                            $menu_configs['menu_item_dropdown_class'],
                            $active,
                            $link
                ]);
            } else {
                $link_active = ($this->checkActive->link($real_link)) ? $menu_configs['link_active_class'] : '';

                $link = Elements::get('link', [
                            $real_link,
                            $menu_configs['link_class'],
                            $link_active,
                            $menu_data->title,
                            $menu_data->icon,
                            $menu_configs['link_before'],
                            $menu_data->title,
                            $menu_configs['link_after']
                ]);

                $active = ($this->checkActive->link($real_link)) ? $menu_configs['menu_item_active_class'] : '';

                $itens .= Elements::get('menu_item', [
                            $menu_configs['menu_item_class'],
                            $active,
                            $link
                ]);
            }
        }

        $menu = Elements::get('menu', [
                    $menu_configs['menu_class'],
                    $menu_configs['menu_id'],
                    $itens
        ]);

        if ($menu_configs['container']) {
            $this->html = Elements::get('container', [
                        $menu_configs['container'],
                        $menu_configs['container_id'],
                        $menu_configs['container_class'],
                        $menu,
                        $menu_configs['container']
            ]);
        } else
            $this->html = $menu;

        return $this->html;
    }
}