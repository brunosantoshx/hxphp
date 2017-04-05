<?php
namespace HXPHP\System\Helpers\Menu;

use HXPHP\System\Configs\Config;
use HXPHP\System\Http\Request;

class Menu
{
    /**
     * Dependências
     * @var object
     */
    private $render = null;

    /**
     * Dados do módulo de configuração
     * @var array
     */
    private $configs = [];

    /**
     * URL ATUAL
     * @var string
     */
    private $current_URL = null;

    /**
     * Nível de acesso
     * @var string
     */
    private $role;

    /**
     * @param Request $request Objeto Request
     * @param Config  $configs Configurações do framework
     * @param string  $role    Nível de acesso
     */
    public function __construct(Request $request, Config $configs, string $role = 'default')
    {
        $this->role = $role;

        $this->setConfigs($configs)
                ->setCurrentURL($request, $configs);

        $realLink = new RealLink($configs->site->url, $configs->baseURI);
        $checkActive = new CheckActive($realLink, $this->current_URL);

        $this->render = new Render(
                $realLink, $checkActive, $this->configs->menu->itens, $this->configs->menu->configs
        );
    }

    /**
     * Dados do módulo de configuração do MenuHelper
     * @param array $configs
     */
    private function setConfigs(Config $configs)
    {
        $this->configs = $configs;

        return $this;
    }

    /**
     * Define a URL atual
     */
    private function setCurrentURL(Request $request, Config $configs)
    {
        $parseURL = parse_url($request->server('REQUEST_URI'));

        $this->current_URL = $configs->site->url . $parseURL['path'];

        return $this;
    }

    /**
     * Exibe o HTML com o menu renderizado
     * @return string
     */
    public function getMenu()
    {
        return $this->render->getHTML($this->role);
    }

    /**
     * Exibe o HTML com o menu renderizado
     * @return string
     */
    public function __toString()
    {
        return $this->getMenu();
    }
}