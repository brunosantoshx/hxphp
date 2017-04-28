<?php
namespace HXPHP\System\Helpers\Table;

class Row
{
    //Armazena o HTML da linha
    private $HTML;
    
    //Armazena o objeto de elementos
    private $elements;
    
    //TAG tr com coringas para substituição 
    private $tag;
    
    //Armazena os atributos da linha
    private $attrs = [];
    
    //Armazena o HTML das células
    private $cells = [];
    
    /**
    * @param string $type Tipo de Tag a ser usada
    * @param array $attrs Atributos da linha
    */
    public function __construct(array $attrs = [], $elements, $tag)
    {        
        foreach ($attrs as $attr => $value)
            $this->attrs[] = ''.$attr.'="'.$value.'"';
        
        $this->elements = $elements;
        $this->tag = $elements->get($tag);
    }
    
    /**
    * Adiciona uma célula
    * @param $cell          Conteúdo e atributos da célula
    */
    public function addCell($cell, string $tag)
    {
        $cell = new Cell($cell, $this->elements, $tag);
        $this->cells[] = $cell->getHTML();
    }
    
    /**
    * Renderiza a linha
    */
    public function render()
    {
        $attrs = implode(' ', $this->attrs);
        
        $cells = implode('', $this->cells);

        $this->HTML = sprintf($this->tag, $attrs, $cells);
    }
    
    /**
    * Exibe o HTML da linha renderizada
    */
    public function getHTML(): string
    {
        $this->render();
                
        return $this->HTML;
    }
}
   