<?php
namespace HXPHP\System\Helpers\Table;

class Template
{
    private $template_path;
    private $template_file;
    
    public function __construct(string $template_file)
    {
        $this->setTemplatePath(TEMPLATES_PATH . 'Helpers' . DS . 'Table' . DS)
                ->setTemplateFile($template_file);
    }

    /**
    * Seta o caminho da pasta do template
    * @param $path Caminho da pasta do template
    */
    public function setTemplatePath(string $path): self
    {
        $this->template_path = $path;

        return $this;
    }

    /**
    * Seta o nome do arquivo do template
    * @param $file Nome do arquivo do template
    */
    public function setTemplateFile(string $file): self
    {
        $this->template_file = $file;

        return $this;
    }
    
    /**
     * Método resposnável pela obtenção do conteúdo do template
     * @return array
     */
    public function get()
    {
        $template = $this->template_path . $this->template_file . '.json';

        if (!file_exists($template))
            throw new \Exception("O template para a tabela nao foi localizado: $template", 1);
        
        $json = json_decode(file_get_contents($template), true);
        
        if (!$json)
            throw new \Exception("Não foi possível obter o conteúdo do template $template. Verifique o código json.", 1);
        
        return $json;
    }
}