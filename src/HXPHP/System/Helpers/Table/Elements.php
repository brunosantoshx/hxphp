<?php
namespace HXPHP\System\Helpers\Table;

class Elements
{
    private $elements;
    
    public function __construct()
    {
        $template_default = new Template('default');
        $this->elements = $template_default->get();
    }
    
    /**
    * Seta o template e dá um merge com o template default
    * @param $template Nome do template
    */
    public function setTemplate(string $template)
    {
        $template = new Template($template);

        if (!is_array($template->get()))
            return false;
        
        $this->elements = array_merge($this->elements, $template->get());
    }
    
    /**
    * Retorna um elemento
    * @param $element Nome do elemento
    * @return string elemento
    */
    public function get($element)
    {
        if (!$this->elements[$element])
            return false;
        
        return $this->elements[$element];
    }
}