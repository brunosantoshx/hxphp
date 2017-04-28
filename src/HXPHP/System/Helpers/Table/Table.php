<?php
namespace HXPHP\System\Helpers\Table;

class Table
{
    public $elements;
    
    //Armazena as rows da tabela
    private $rows = [];
    
    //Armazena as linhas do cabeçalho
    public $header = [];
    
    //Armazena as linhas do rodapé
    private $footer = [];
    
    //Armazena o conteudo da caption
    private $caption;
    
    //Armazena os atributos da tag <caption>
    private $caption_attrs = [];
    
    //Armazena os atributos da tag <table>
    private $table_attrs = [];
    
    //Armazena os atributos da tag <thead>
    private $thead_attrs = [];
    
    //Armazena os atributos da tag <tbody>
    private $tbody_attrs = [];
    
    //Armazena os atributos da tag <tfoot>
    private $tfoot_attrs = [];
    
    public function __construct($template = null)
    {
        $this->elements = new Elements;

        if ($template)
            $this->elements->setTemplate($template);
    }    
    
    /**
    * Adiciona uma linha à tabela
    * @param array $cells   Celulas da linha
    * @param array $attrs   Atributos da linha
    */
    public function addRow(array $cells, array $attrs = [])
    {
        $row = new Row($attrs, $this->elements, 'tag_tbody_row');

        foreach ($cells as $cell)
            $row->addCell($cell, 'tag_tbody_cell');
        
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
        $row = new Row($attrs, $this->elements, 'tag_thead_row');
        
        foreach ($cells as $cell)
            $row->addCell($cell, 'tag_thead_cell');
        
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
        $row = new Row($attrs, $this->elements, 'tag_tfoot_row');
        
        foreach ($cells as $cell)
            $row->addCell($cell, 'tag_tfoot_cell');
        
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
        
        $attrs = implode($this->caption_attrs);
        
        $this->caption = sprintf($this->elements->get('tag_caption'), $attrs, $content);
    }
    
    /**
    * Captura o conteúdo de Caption
    * @return array Conteúdo e atributos da tag caption
    */
    public function getCaption()
    {
        return $this->caption;
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
    * @return HTML da tabela
    */
    public function getTable(): string
    {
        $render = new Render($this);
        return $render->getHTML();
    }
    
    /**
    * Exibe o HTML renderizado
    * @return Tabela renderizada
    */
    public function __toString(): string
    {
        return $this->getTable();
    }    
}