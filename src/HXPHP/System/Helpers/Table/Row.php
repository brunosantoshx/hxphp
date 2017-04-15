<?php
namespace HXPHP\System\Helpers\Table;

class Row
{
    //Armazena o HTML da linha
    private $HTML;
    
    //TAG tr com coringas para substituição (tag para o corpo da tabela)
    private $tr = '<tr %s>%s</tr>';
    
    //Armazena os atributos da linha
    private $attrs = [];
    
    //Armazena o HTML das células
    private $cells = [];
    
    /**
    * @param string $type Tipo de Tag a ser usada
    * @param array $attrs Atributos da linha
    */
    public function __construct(array $attrs = [])
    {        
        foreach ($attrs as $attr => $value)
            $this->attrs[] = ''.$attr.'="'.$value.'"';
    }
    
    /**
    * Adiciona uma célula
    */
    public function addCell(string $type, $cell)
    {
        $cell = new Cell($type, $cell);
        $this->cells[] = $cell->getHTML();
    }
    
    public function render()
    {
        $attrs = implode(' ', $this->attrs);
        
        $cells = implode('', $this->cells);
        
        $this->HTML = sprintf($this->tr, $attrs, $cells);
    }
    
    public function getHTML(): string
    {
        $this->render();
        return $this->HTML;
    }
}
   