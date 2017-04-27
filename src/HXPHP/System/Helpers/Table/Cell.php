<?php
namespace HXPHP\System\Helpers\Table;

class Cell
{
    //Armazena o HTML da célula
    private $HTML;
    
    //Armazena o conteúdo da célula em si (a ser exibido)
    private $content;
    
    //Armazena os atributos da célula
    private $attrs = [];
    
    //TAG HTML para celulas do corpo da tabela
    private $tag;
    
    /**
    * @param string $cell       Conteudo da celula, e pode conter atributos
    */
    public function __construct($cell, $elements, $tag)
    {
        if (is_array($cell)) {
            
            //O primeiro elemento é sempre o conteúdo da célula
            $this->content = array_shift($cell);
            
            //Os demais elementos são atributos da célula
            $attrs = $cell;
            
            foreach ($attrs as $attr => $value)
                $this->attrs[] = ''.$attr.'="'.$value.'"';
        }
        else
            $this->content = $cell;
        
        $this->tag = $elements->get($tag) ;
    }
    
    /*
    * Renderiza a célula e armazena no atributo 'HTML' desta classe
    */
    public function render()
    {
        $attrs = implode(' ', $this->attrs);
        
        $this->HTML = sprintf($this->tag, $attrs, $this->content);
    }
    
    /*
    * Exibe o HTML da célula renderizada
    * @return string do HTML da célula
    */
    public function getHTML(): string
    {
        $this->render();
        return $this->HTML;
    }
}