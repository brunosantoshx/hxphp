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
    
    public function setTemplate(string $template)
    {
        $template = new Template($template);

        if (!is_array($template->get()))
            return false;
        
        $this->elements = array_merge($this->elements, $template->get());
    }
    
    public function get($element)
    {
        if (!$this->elements[$element])
            return false;
        
        return $this->elements[$element];
    }
}