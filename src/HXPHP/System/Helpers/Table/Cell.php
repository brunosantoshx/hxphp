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
    
    //Armazena os atributos da célula
    private $type;
    
    //TAG HTML para celulas do corpo da tabela
    private $td = '<td %>%s</td>';
    
    //TAG HTML para celulas do Cabeçalho
    private $th = '<th %>%</th>';
    
    public function _construct(string $type, string $content, array $attrs = [])
    {
        $this->content = $content;
        
        if ($type !== 'td' || $type !== 'th')
            throw new \Exception("O tipo $type de Célula não existe");
        else
            $this->type = $type;        
        
        if ($attrs)
            foreach ($attrs as $attr => $value)
                $this->attrs[] = ''.$attr.' = "'.$value.'"';
    }
    
    public function getHTML(): string
    {
        $attrs = implode(' ', $this->attrs);
        
        $type = $this->type;
        
        $html = sprintf($this->$type, $attrs, $this->content);
        
        return $html;
    }
}