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

    public function setTemplatePath(string $path): self
    {
        $this->template_path = $path;

        return $this;
    }

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

        return json_decode(file_get_contents($template), true);
    }
}