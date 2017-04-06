<?php
namespace HXPHP\System\Helpers\Menu;

class CheckActive
{
    /**
     * Dependências
     * @var object
     */
    private $realLink = null;

    /**
     * URL atual
     * @var string
     */
    private $current_URL = null;

    public function __construct(RealLink $realLink, string $current_URL)
    {
        $this->realLink = $realLink;
        $this->current_URL = $current_URL;
    }

    /**
     * Verifica se o link está ativo
     * @param  string $URL Link do menu
     * @return bool        Status do link
     */
    public function link(string $URL): bool
    {
        $position = strpos($this->current_URL, $URL);
        return $this->current_URL === $URL || ($position && $position > 0) ? true : false;
    }

    /**
     * Verifica se algum link do dropdown está ativo
     * @param  array $values Links do dropdown
     * @return bool        	 Status do dropdown
     */
    public function dropdown(array $values): bool
    {
        $values = array_values($values);
        $status = false;

        foreach ($values as $dropdown_link) {
            $real_link = $this->realLink->get($dropdown_link);

            if ($this->link($real_link)) {
                $status = true;
                break;
            }
        }
        return $status;
    }
}