<?php
namespace HXPHP\System\Modules\Messages;

use HXPHP\System\Tools as Tools;

class LoadTemplate
{
    /**
     * JSON do template
     * @var json
     */
    private $json;

    /**
     * Caminho do template
     * @var string
     */
    public $file = null;

    /**
     * Método responsável pela leitura do arquivo JSON
     * @param string $template Nome do template
     */
    public function __construct($template, $extension = '.json')
    {
        /**
         * Caminho completo do template
         * @var string
         */
        $template = Tools::getTemplatePath('Modules', 'Messages', $template . $extension);

        $this->file = $template;
        $this->json = file_get_contents($template);
    }

    /**
     * Retorna o conteúdo do template
     * @return json
     */
    public function getJson()
    {
        return empty($this->json) ? false : $this->json;
    }

    /**
     * Retorna o caminho do template
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->file;
    }
}