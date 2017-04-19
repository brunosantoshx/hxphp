<?php
namespace HXPHP\System\Helpers\Table;

class Table
{
    //Armazena as rows da tabela
    private $rows = [];
    
    //Armazena as linhas do cabeçalho
    public $header = [];
    
    //Armazena as linhas do rodapé
    private $footer = [];
    
    //Armazena o conteudo da caption
    private $caption_content;
    
    //Armazena os atributos da tag <caption>
    private $caption_attrs = []; 
    
    //Tag da tabela com coringas
    private $tag_table = '<table %s>%s</table>';
    
    //Armazena os atributos da tag <table>
    private $table_attrs = [];
    
    //Tag do cabeçalho com coringas
    private $tag_thead = '<thead %s>%s</thead>';
    
    //Armazena os atributos da tag <thead>
    private $thead_attrs = [];
    
    //Tag do corpo da tabela com coringas
    private $tag_tbody = '<tbody %s>%s</tbody>';
    
    //Armazena os atributos da tag <tbody>
    private $tbody_attrs = [];
    
    //Tag do rodapé com coringas
    private $tag_tfoot = '<tfoot %s>%s</tfoot>';
    
    //Armazena os atributos da tag <tfoot>
    private $tfoot_attrs = [];
    
    
    /**
    * Adiciona uma linha à tabela
    * @param array $cells   Celulas da linha
    * @param array $attrs   Atributos da linha
    */
    public function addRow(array $cells, array $attrs = [])
    {
        $row = new Row($attrs);
        
        foreach ($cells as $cell)
            $row->addCell('td', $cell);
        
        $this->rows[] = $row->getHTML();
    }
    
    /**
    * Adiciona mais de uma linha à tabela
    * @param array $rows    Linhas a serem adicionadas à tabela
    * @param array $attrs   Atributos das linhas
    */
    public function addRows(array $rows, array $attrs = [])
    {
        foreach ($rows as $cells)
            $this->addRow($cells, $attrs);            
    }
    
    /**
    * Retorna as linhas do corpo da tabela
    * @return array Atributo $rows desta classe
    */
    public function getRows(): array
    {
        return $this->rows;
    }
    
    /*
    * Adiciona linha de cabeçalho
    * @param $cells         Celulas do cabeçalho
    * @param array $attrs   Atributos da linha
    */
    public function addHeader(array $cells, $attrs = [])
    {
        $row = new Row($attrs);
        
        foreach ($cells as $cell)
            $row->addCell('th', $cell);
        
        $this->header[] = $row->getHTML();
    }
    
    /**
    * Retorna as linhas do cabeçalho da tabela
    * @return array Atributo $header desta classe
    */
    public function getHeader(): array
    {
        return $this->header;
    }
    
    /*
    * Adiciona linha de rodapé
    * @param $cells         Celulas do rodapé
    * @param array $attrs   Atributos da linha
    */
    public function addFooter(array $cells, $attrs = [])
    {
        $row = new Row($attrs);
        
        foreach ($cells as $cell)
            $row->addCell('th', $cell);
        
        $this->footer[] = $row->getHTML();
    }
    
    /**
    * Retorna as linhas do rodapé da tabela
    * @return array Atributo $footer desta classe
    */
    public function getFooter(): array
    {
        return $this->footer;
    }
    
    /**
    * Adiciona caption à tabela
    * @param string $content    Conteúdo do caption
    * @param array $attrs       Atributos da tag caption
    */
    public function addCaption(string $content, array $attrs = [])
    {
        if ($attrs)
            foreach ($attrs as $attr => $value)
                $this->caption_attrs[] = $attr.'="'.$value.'"';
        
        $this->caption_content = $content;
    }
    
    /**
    * Captura o conteúdo de Caption
    * @return array Conteúdo e atributos da tag caption
    */
    public function getCaption(): array
    {
        $caption['content'] = $this->caption_content;
        $caption['attrs'] = $this->caption_attrs;
        
        return $caption;
    }
    
    /**
    * Seta atributo para a tag <table>
    */
    public function addTagAttr(string $tag, array $attrs)
    {
        $prop = $tag.'_attrs';
        
        if (property_exists($this, $prop))
            foreach ($attrs as $attr => $value)
                $this->$prop[] = $attr.'="'.$value.'"';
        else
            throw new \Exception("A tag $tag não existe ou não pode ser manipulada desta maneira.");
    }
    
    /**
    * Método mágico get para ser usado pelo render
    */
    public function __get($prop)
    {
        if (property_exists($this, $prop))
            return $this->$prop;
        else
            throw new \Exception("A propriedade $prop não existe");
    }
    
    /**
    * Exibe o HTML com a tabela renderizada
    */
    public function getTable(): string
    {
        $render = new Render($this);
        return $render->getHTML();
    }
    
    /**
    * Exibe o HTML renderizado
    */
    public function __toString(): string
    {
        return $this->getTable();
    }    
}