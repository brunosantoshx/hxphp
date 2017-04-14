<?php
namespace HXPHP\System\Helpers\Table;

class Row
{
    //Armazena o HTML da linha
    private $HTML;
    
    //Tipo de linha(tag)
    private $type;
    
    //TAG tr com coringas para substituição (tag para o corpo da tabela)
    private $tr = '<tr %s>%s</tr>';
    
    //TAG thead com coringas para substituição (tag para o cabeçalho da tabela)
    private $thead = '<thead %s>%s</thead>';
    
    //Armazena os atributos da linha
    private $attrs = [];
    
    //Armazena o HTML das células
    private $cells = [];
    
    /**
    * @param string $type Tipo de Tag a ser usada
    * @param array $attrs Atributos da linha
    */
    public function __construct(string $type, array $attrs = [])
    {
        $this->type = $type;
        $this->attrs = $attrs;
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
        $type = $this->type;
        
        $attrs = implode(' ', $this->attrs);
        
        $cells = implode('', $this->cells);
        
        $this->HTML = sprintf($this->$type, $attrs, $cells);
    }
    
    public function getHTML(): string
    {
        $this->render();
        return $this->HTML;
    }
}
   